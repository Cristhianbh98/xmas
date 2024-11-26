<?php

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class RepresentanteFormSchema
{
    public static function get(): array
    {
        return [
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
                ->helperText('Debe contener 10 dígitos numéricos')
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
        ];
    }
}
