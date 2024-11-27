<?php

namespace Database\Seeders;

use App\Models\Cdc;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SplFileObject;

class CdcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new SplFileObject(database_path('seeders/cdc.csv'));
        $data->setFlags(SplFileObject::READ_CSV);
        $data->setCsvControl(',');
        $it = new \LimitIterator($data, 1);
        foreach ($it as $row) {
            Cdc::create([
                'name' => Str::ascii($row[0] ?? ''),
                'address' => Str::ascii($row[1] ?? ''),
                'gps' => Str::ascii($row[2] ?? ''),
                'presidente' => Str::ascii($row[3] ?? ''),
                'phone' => Str::ascii($row[4] ?? ''),
                'email' => Str::ascii($row[5] ?? ''),
                'created_at' => now(),
            ]);
        }
    }
}
