<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'position',
        'department',
        'status',
        'hire_date',
        'avatar_url',
        'skills'
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);

    }
}