<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'manager_id'];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    public function recrutements()
    {
        return $this->hasMany(Recrutement::class);
    }

}