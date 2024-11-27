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
        'cdc_id',
        'cdi_id',
        'barrio_id',
        'parroquia_id',
        'created_by',
        'updated_by'
    ];

    public function representante() {
        return $this->belongsTo(Representante::class);
    }

    public function cdc() {
        return $this->belongsTo(Cdc::class);
    }

    public function cdi() {
        return $this->belongsTo(Cdi::class);
    }
}
