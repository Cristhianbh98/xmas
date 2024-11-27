<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'presidente',
        'phone',
        'parroquia_id',
        'created_by',
        'updated_by'
    ];

    public function parroquia() {
        return $this->belongsTo(Parroquia::class);
    }
}
