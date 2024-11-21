<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    // Campos asignables en masa
    protected $fillable = [
        'nombre', 
        'descripcion', 
        'dificultad', 
        'duracion_estimada', 
        'exercise_type_id', 
        'estado', 
        'imagen_url', 
        'video_url'
    ];

    // Relación: Un ejercicio pertenece a un tipo de ejercicio
    public function exerciseType()
    {
        return $this->belongsTo(ExerciseType::class, 'exercise_type_id');
    }
}
