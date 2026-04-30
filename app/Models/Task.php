<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'user_id', 'title', 'description', 'priority', 'due_date', 'is_completed'
    ];

    protected $casts = [
<<<<<<< HEAD
        'due_date' => 'date',
        'is_completed' => 'boolean',
=======
        'start' => 'date:Y-m-d',
        'end' => 'date:Y-m-d',
>>>>>>> 47040dd5ca2c2dfbee19815dfa84fc013cd8a3d6
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}