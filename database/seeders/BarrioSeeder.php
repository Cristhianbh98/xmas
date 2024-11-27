<?php

namespace Database\Seeders;

use App\Models\Barrio;
use App\Models\Parroquia;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SplFileObject;

class BarrioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new SplFileObject(database_path('seeders/barrios.csv'));
        $data->setFlags(SplFileObject::READ_CSV);
        $data->setCsvControl(',');
        $it = new \LimitIterator($data, 1);
        foreach ($it as $row) {
            $pr = $row[3];
            $parroquia_id = null;

            if ($pr) {
                $parroquia = Parroquia::where('name', $pr)->first();
                if ($parroquia) {
                    $parroquia_id = $parroquia->id;
                }
            }

            Barrio::create([
                'name' => Str::ascii($row[0] ?? ''),
                'presidente' => Str::ascii($row[1] ?? ''),
                'phone' => $row[2] ?? '',
                'parroquia_id' => $parroquia_id,
                'created_at' => now(),
            ]);
        }
    }
}
