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
        'created_by',
        'updated_by'
    ];
}
