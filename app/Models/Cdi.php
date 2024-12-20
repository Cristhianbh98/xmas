<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'barrio',
        'parroquia',
        'address',
        'gps',
    ];

    public function estudiantes() {
        return $this->hasMany(Estudiante::class);
    }
}
