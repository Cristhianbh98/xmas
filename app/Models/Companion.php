<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companion extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'cedula',
        'phone',
        'email'
    ];

    public function attendee() {
        return $this->belongsTo(Attendee::class);
    }
}
