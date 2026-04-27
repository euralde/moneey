<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recrutement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'departement_id',
        'title',
        'description',
        'requirements',
        'location',
        'status',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class);
    }
}