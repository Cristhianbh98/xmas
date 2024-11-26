<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepresentanteResource\Pages;
use App\Filament\Resources\RepresentanteResource\RelationManagers;
use App\Models\Representante;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Forms
use Filament\Forms\Components\TextInput;

// Tables
use Filament\Tables\Columns\TextColumn;

class RepresentanteResource extends Resource
{
    protected static ?string $model = Representante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

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
                    ->unique()
                    ->regex('/^[0-9]{10}$/')
                    ->required(),
                Select::make('parentesco')
                    ->label('Parentesco')
                    ->options([
                        'papa' => 'Papá',
                        'mama' => 'Mamá',
                    ])
                    ->required(),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cedula')
                    ->label('Cédula')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Nombres')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Apellidos')
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
            'index' => Pages\ListRepresentantes::route('/'),
            'create' => Pages\CreateRepresentante::route('/create'),
            'edit' => Pages\EditRepresentante::route('/{record}/edit'),
        ];
    }
}
