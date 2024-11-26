<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class DatabaseActions extends Widget {
    public $name;

    protected static string $view = 'filament.widgets.database-actions';

    public static function canView(): bool {
        return Auth::user()->role === 'admin';
    }

    public function clearDatabase() {
        if ( $this->name === 'ELIMINAR' ) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');

            // Clear tables
            DB::table('companions')->truncate();
            DB::table('attendees')->truncate();

            DB::statement('SET FOREIGN_KEY_CHECKS=1');

            session()->flash('message', 'La base de datos ha sido limpiada...');
        } else {
            session()->flash('message', 'El valor ingresado no es correcto...');
        }

        $this->name = '';
    }
}
