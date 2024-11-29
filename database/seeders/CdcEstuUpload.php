<?php

namespace Database\Seeders;

use App\Models\Parroquia;
use App\Models\Representante;
use App\Models\Cdc;
use App\Models\Estudiante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SplFileObject;

class CdcEstuUpload extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new SplFileObject(database_path('seeders/cdc_estudiantes_subir.csv'));
        $data->setFlags(SplFileObject::READ_CSV);
        $data->setCsvControl(',');
        $it = new \LimitIterator($data, 1);
        foreach ($it as $row) {
            $rep_row = ($row[0] ?? '');
            $representante = Representante::where('cedula', $rep_row)->first();
            if (!$representante) {
                $representante = Representante::create([
                    'cedula' => $rep_row,
                    'last_name' => ($row[1] ?? ''),
                    'first_name' => ($row[2] ?? ''),
                    'phone' => ($row[3] ?? ''),
                    'email' => ($row[4] ?? '')
                ]);
            }

            $parroquia_row = ($row[8] ?? '');
            $parroquia = Parroquia::where('name', $parroquia_row)->first();

            if (!$parroquia) {
                $parroquia = Parroquia::create([
                    'name' => $parroquia_row
                ]);
            }

            $barrio_row = ($row[9] ?? '');
            $barrio = $parroquia->barrios()->where('name', $barrio_row)->first();
            if (!$barrio) {
                $barrio = $parroquia->barrios()->create([
                    'name' => $barrio_row
                ]);
            }

            $cdc_row = ($row[10] ?? '');
            $cdc = Cdc::where('name', $cdc_row)->first();
            if (!$cdc) {
                $cdc = Cdc::create([
                    'name' => $cdc_row
                ]);
            }

            Estudiante::create([
                'representante_id' => $representante->id,
                'cedula' => ($row[5] ?? ''),
                'last_name' => ($row[6] ?? ''),
                'first_name' => ($row[7] ?? ''),
                'tipo_entrega' => 'cdc',
                'barrio_id' => $barrio->id,
                'parroquia_id' => $parroquia->id,
                'cdc_id' => $cdc->id
            ]);
        }
    }
}
