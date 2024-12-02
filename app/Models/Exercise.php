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

    public function routines()
    {
        return $this->belongsToMany(Routine::class, 'routine_exercise');
    }
    
    public function exerciseType()
    {
        return $this->belongsTo(ExerciseType::class, 'exercise_type_id');
    }


    public function exerciseMuscles()
    {
        return $this->hasMany(ExerciseMuscle::class, 'exercise_id');
    }

    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'exercise_muscle', 'exercise_id', 'muscle_id')
            ->withPivot('intensidad')
            ->withTimestamps();
    }
}
