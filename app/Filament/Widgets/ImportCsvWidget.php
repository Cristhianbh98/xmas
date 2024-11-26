<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

use Livewire\WithFileUploads;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ImportCsvWidget extends Widget {
    use WithFileUploads;
    public $file;
    protected static string $view = 'filament.widgets.import-csv-widget';

    public static function canView(): bool {
        return Auth::user()->role === 'admin';
    }

    public function importCsv() {
        $this->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $path = $this->file->store('csv_files');

        $data = array_map('str_getcsv', file(storage_path('app/' . $path)));

        $header = array_shift($data);
        $header = $this->clearBom($header);

        foreach ($data as $row) {
            $row = array_combine($header, $row);
            DB::table('attendees')->insert([
                'name' => $row['name'],
                'cedula' => $row['cedula'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'address' => $row['address'],
                'created_by' => Auth::user()->id,
                'updated_by' =>  Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        session()->flash('message', 'Datos importados exitosamente.');
    }

    // Function
    private function clearBom($header) {
        $header = array_map(function($value) {
            return preg_replace('/\x{FEFF}/u', '', $value);
        }, $header);

        return $header;
    }
}
