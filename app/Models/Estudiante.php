<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'cedula',
        'last_name',
        'first_name',
        'age',
        'representante_id',
        'tipo_entrega',
        'created_by',
        'updated_by'
    ];

    public function representante() {
        return $this->belongsTo(Representante::class);
    }
}
