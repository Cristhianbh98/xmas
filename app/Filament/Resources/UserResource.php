<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Symfony\Component\Console\Input\Input;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $label = 'Usuario';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->autocomplete(false)
                    ->required(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->autocomplete(false)
                    ->revealable()
                    ->required(fn ($context) => $context === 'create')
                    ->rules(fn ($context) => $context === 'create' ? ['confirmed', Password::defaults()] : ['nullable', 'confirmed', Password::defaults()]),
                TextInput::make('password_confirmation')
                    ->label('Confirmar contraseña')
                    ->password()
                    ->autocomplete(false)
                    ->revealable()
                    ->required(fn ($context) => $context === 'create')
                    ->rules(fn ($context) => $context === 'create' ? ['required'] : ['nullable']),
                Select::make('role')
                    ->label('Rol')
                    ->options([
                        'user' => 'Usuario',
                        'admin' => 'Administrador',
                        'cdc/cdi' => 'CDC/CDI',
                        'd-barrio' => 'Dirigente Barrial',
                        'g-parroquias' => 'Gestor General'
                    ])
                    ->default('user')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nombre'),
                TextColumn::make('email')
                    ->label('Correo electrónico'),
                TextColumn::make('role')
                    ->label('Rol')
                    ->formatStateUsing(function ( $state ) {
                        return match ($state) {
                            'admin' => 'Administrador',
                            'user' => 'Usuario',
                            default => $state,
                        };
                    }),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canAccess(): bool {
        return Auth::user()->role === 'admin';
    }
}
