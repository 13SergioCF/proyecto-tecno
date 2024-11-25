<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Muscle extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'muscles';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_muscle')
            ->withPivot('intensidad')
            ->withTimestamps();
    }

    public function scopeActivo($query)
    {
        return $query->where('estado', 'activo');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_muscle', 'muscle_id', 'user_id')
            ->withTimestamps();
    }
}
