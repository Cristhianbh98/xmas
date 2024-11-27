<?php

namespace Database\Seeders;

use App\Models\Cdi;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new \SplFileObject(database_path('seeders/cdi.csv'));
        $data->setFlags(\SplFileObject::READ_CSV);
        $data->setCsvControl(',');
        $it = new \LimitIterator($data, 1);
        foreach ($it as $row) {
            Cdi::create([
                'name' => Str::ascii($row[0] ?? ''),
                'barrio' => Str::ascii($row[1] ?? ''),
                'parroquia' => Str::ascii($row[2] ?? ''),
                'address' => Str::ascii($row[3] ?? ''),
                'gps' => Str::ascii($row[4] ?? '')
            ]);
        }
    }
}
