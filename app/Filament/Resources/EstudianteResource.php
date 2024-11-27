<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstudianteResource\Pages;
use App\Filament\Resources\EstudianteResource\RelationManagers;
use App\Models\Estudiante;
use App\Models\Representante;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Forms
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use RepresentanteFormSchema;

// Tables
use Filament\Tables\Columns\TextColumn;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 3;

    protected static ?string $label = 'Niño';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->label('Nombres')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Apellidos')
                    ->required(),
                TextInput::make('cedula')
                    ->label('Cédula')
                    ->unique(Estudiante::class, 'cedula', ignoreRecord: true)
                    ->regex('/^[0-9]{10}$/')
                    ->helperText('Debe contener 10 dígitos numéricos')
                    ->required(),
                TextInput::make('age')
                    ->label('Edad')
                    ->numeric()
                    ->required(),
                Select::make('representante_id')
                    ->label('Representante')
                    ->options(
                        Representante::all()
                            ->mapWithKeys(
                                function ($representante) {
                                    return [$representante->id => $representante->cedula . ' - ' . $representante->first_name . ' ' . $representante->last_name];
                                }
                            )
                    )
                    ->createOptionForm(RepresentanteFormSchema::get())
                    ->createOptionUsing(
                        function (array $data) {
                            $representante = Representante::create($data);
                            return $representante->id;
                        }
                    )
                    ->searchable()
                    ->required(),
                    /* ->getSearchResultsUsing(
                        function (string $search) {
                            return Representante::query()
                                ->where('cedula', 'like', '%'. $search . '%')
                                ->orWhere('first_name', 'like', '%'. $search . '%')
                                ->orWhere('last_name', 'like', '%' . $search . '%' )
                                ->get()
                                ->mapWithKeys(
                                    function ($representante) {
                                        return [$representante->id => $representante->cedula . ' - ' . $representante->first_name . ' ' . $representante->last_name];
                                    }
                                );
                        }
                    ) */
                Select::make('tipo_entrega')
                    ->label('Tipo de Entrega')
                    ->options([
                        'cdc' => 'CDC',
                        'cdi' => 'CDI',
                        'patronato' => 'Patronato',
                        'colegio' => 'Colegio',
                        'barrio' => 'Barrio',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('Nombres')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Apellidos')
                    ->searchable(),
                TextColumn::make('cedula')
                    ->label('Cédula')
                    ->searchable(),
                TextColumn::make('age')
                    ->label('Edad')
                    ->searchable(),
                TextColumn::make('representante.cedula')
                    ->label('Representante')
                    ->searchable(),
                TextColumn::make('tipo_entrega')
                    ->label('Tipo de Entrega')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstudiantes::route('/'),
            'create' => Pages\CreateEstudiante::route('/create'),
            'edit' => Pages\EditEstudiante::route('/{record}/edit'),
        ];
    }
}
