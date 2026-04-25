<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'titre',
        'contenu',
        'expediteur',
        'destinataire',
        'status'
    ];
}