<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cedula',
        'phone',
        'email',
        'address',
        'comment',
        'attendance',
        'parallel',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'attendance' => 'boolean',
    ];

    public function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function companions() {
        return $this->hasMany(Companion::class);
    }
}
