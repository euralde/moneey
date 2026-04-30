<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'lastname',
        'firstname',
        'email',
        'phone',
        'password',
        'profil',
        'status',
        'departement_id',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    // Relations
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function managedDepartement()
    {
        return $this->hasOne(Departement::class, 'manager_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function recrutements()
    {
        return $this->hasMany(Recrutement::class);
    }

    public function conversations()
    {
        return Conversation::where('sender_id', $this->id)
            ->orWhere('receiver_id', $this->id);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function reunions()
    {
        return $this->hasMany(Reunion::class, 'created_by');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }
}