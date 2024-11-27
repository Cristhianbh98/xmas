<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'created_by',
        'updated_by'
    ];

    public function barrios() {
        return $this->hasMany(Barrio::class);
    }
}
