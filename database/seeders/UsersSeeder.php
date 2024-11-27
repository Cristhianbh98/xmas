<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Parroquia;
use App\Models\Barrio;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use SplFileObject;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = new SplFileObject(database_path('seeders/users.csv'));
        $data->setFlags(SplFileObject::READ_CSV);
        $data->setCsvControl(',');
        $it = new \LimitIterator($data, 1);
        foreach ($it as $row) {
            $pr = $row[3];
            $parroquia_id = null;
            $barrio_id = null;

            if ($pr) {
                $parroquia = Parroquia::where('name', $pr)->first();
                if ($parroquia) {
                    $parroquia_id = $parroquia->id;
                }
            }

            if ($parroquia_id) {
                $br = Str::ascii($row[4] ?? '');
                $barrio = Barrio::where('parroquia_id', $parroquia_id)->where('name', $br)->first();
                if ($barrio) {
                    $barrio_id = $barrio->id;
                }
            }

            User::create([
                'name' =>  Str::ascii($row[0]),
                'email' => $row[1],
                'password' => bcrypt($row[2]),
                'email_verified_at' => now(),
                'role' => 'd-barrio',
                'barrio_id' => $barrio_id,
            ]);
        }
    }
}
