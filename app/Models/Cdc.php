<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdc extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'gps',
        'presidente',
        'phone',
        'email',
        'created_at',
    ];
}
