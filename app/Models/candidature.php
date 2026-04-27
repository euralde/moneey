<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'recrutement_id',
        'name',
        'email',
        'phone',
        'cv_url',
        'lettre_motivation',
        'status',
        'notes'
    ];

    public function recrutement()
    {
        return $this->belongsTo(Recrutement::class);
    }
}