<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $fillable = [
        'cedula',
        'parentesco',
        'last_name',
        'first_name',
        'email',
        'phone',
        'created_by',
        'updated_by'
    ];

    public function getNombreCompletoAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function estudiantes() 
    {
        return $this->hasMany(Estudiante::class);
    }
}
