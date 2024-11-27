<?php

namespace Database\Seeders;

use App\Models\Parroquia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ParroquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parroquias = ['ELOY ALFARO', 'LOS ESTEROS', 'MANTA', 'SAN LORENZO', 'SAN MATEO', 'SANTA MARIANITA', 'TARQUI'];
        
        foreach ($parroquias as $parroquia) {
            Parroquia::create(['name' => $parroquia]);
        }
    }
}
