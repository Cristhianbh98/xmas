<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SplFileObject;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new SplFileObject(database_path('seeders/attendees.csv'));
        $data->setFlags(SplFileObject::READ_CSV);
        $data->setCsvControl(',');
        $it = new \LimitIterator($data, 1);
        foreach ($it as $row) {
            if (
                $row[0] === '' &&
                $row[1] === '' &&
                $row[2] === '' &&
                $row[3] === '' &&
                $row[4] === '' &&
                $row[5] === ''
            ) {
                continue;
            }

            DB::table('attendees')->insert([
                'name' => $row[0] ?? '',
                'cedula' => $row[1] ?? '',
                'phone' => $row[2] ?? '',
                'email' => $row[3] ?? '',
                'address' => $row[4] ?? '',
                'parallel' => $row[5] ?? '',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
            ]);
        }
    }
}
