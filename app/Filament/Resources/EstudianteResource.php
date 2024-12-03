<?php

namespace App\Filament\Resources;

use App\Filament\Exports\EstudianteExporter;
use App\Filament\Resources\EstudianteResource\Pages;
use App\Filament\Resources\EstudianteResource\RelationManagers;
use App\Models\Barrio;
use App\Models\Cdc;
use App\Models\Cdi;
use App\Models\Estudiante;
use App\Models\Parroquia;
use App\Models\Representante;
use Faker\Provider\ar_EG\Text;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\ExportAction;

// Forms
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use RepresentanteFormSchema;

// Tables
use Filament\Tables\Columns\TextColumn;
use PhpParser\Node\Expr\Cast\Bool_;
use Illuminate\Support\Facades\Auth;

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
                    ->options(
                        function () {
                            $role = Auth::user()->role;

                            if ($role === 'cdc/cdi') {
                                return [
                                    'cdc' => 'CDC',
                                    'cdi' => 'CDI',
                                ];
                            }

                            if ($role === 'd-barrio') {
                                return [
                                    'barrio' => 'Barrio',
                                ];
                            }

                            return [
                                'cdc' => 'CDC',
                                'cdi' => 'CDI',
                                'patronato' => 'Patronato',
                                'barrio' => 'Barrio',
                            ];
                        }
                    )
                    ->default(
                        function() {
                            $role = Auth::user()->role;

                            if ($role === 'd-barrio') {
                                return 'barrio';
                            }

                            return '';
                        }
                    )
                    ->live()
                    ->required(),               
                Select::make('cdc_id')
                    ->label('CDC')
                    ->options(Cdc::all()->pluck('name', 'id'))
                    ->visible(
                        function (Get $get): bool {
                            return $get('tipo_entrega') === 'cdc';
                        }
                    )
                    ->required(),
                Select::make('cdi_id')
                    ->label('CDI')
                    ->options(Cdi::all()->pluck('name', 'id'))
                    ->visible(
                        function (Get $get): bool {
                            return $get('tipo_entrega') === 'cdi';
                        }
                    )
                    ->required(),
                Select::make('barrio_id')
                    ->label('Barrio')
                    ->options(
                        function() {
                            $user = Auth::user();

                            if ($user->role === 'd-barrio') {
                                return Barrio::where('id', $user->barrio_id)->pluck('name', 'id');
                            }

                            return Barrio::all()->pluck('name', 'id');
                        }
                    )
                    ->default(
                        function() {
                            $user = Auth::user();

                            if ($user->role === 'd-barrio') {
                                return $user->barrio_id;
                            }

                            return '';
                        }
                    )
                    ->visible(
                        function (Get $get): bool {
                            return $get('tipo_entrega') === 'barrio';
                        }
                    )
                    ->hidden(
                        function (): bool {
                            $user = Auth::user();
                            return $user->role !== 'd-barrio';
                        }
                    )
                    ->required(),
                Select::make('parroquia_id')
                    ->label('Parroquia')
                    ->options(Parroquia::all()->pluck('name', 'id'))
                    ->live()
                    ->visible(
                        function (Get $get): bool {
                            return $get('tipo_entrega') === 'barrio';
                        }
                    )
                    ->hidden(
                        function (): bool {
                            $user = Auth::user();
                            return $user->role === 'd-barrio';
                        }
                    )
                    ->afterStateUpdated(
                        function($state, Set $set) {
                            $set('barrio_id', null);
                        }
                    )
                    ->required(),
                Select::make('barrio_id')
                    ->label('Barrio')
                    ->searchable()
                    ->options(
                        function (Get $get) {
                            return Barrio::where('parroquia_id', $get('parroquia_id'))->pluck('name', 'id');
                        }
                    )
                    ->visible(
                        function (Get $get): bool {
                            return $get('tipo_entrega') === 'barrio';
                        }
                    )
                    ->hidden(
                        function (Get $get): bool {
                            $user = Auth::user();
                            return $user->role === 'd-barrio' || !$get('parroquia_id');
                        }
                    )
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
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Exportar a Excel')
                    ->formats([ExportFormat::Csv])
                    ->exporter(EstudianteExporter::class)
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

    public static function getTableQuery(): Builder
    {
        $user = Auth::user();

        if ($user->role === 'cdc/cdi') {
            return static::getModel()::query()
                ->where('tipo_entrega', 'cdc')
                ->orWhere('tipo_entrega', 'cdi');
        }

        return static::getModel()::query();
    }
}
