<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'last_message', 'last_message_at'];

    protected $casts = [
        // 'last_message_at' => 'datetime',
    ];

    public function sender_id()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver_id()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getOtherParticipant($userId)
    {
        if ($this->participant1_id == $userId) {
            return $this->participant2;
        }
        return $this->participant1;
    }
}