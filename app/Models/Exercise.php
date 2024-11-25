<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'dificultad',
        'duracion_estimada',
        'exercise_type_id',
        'estado'
    ];
    public function exerciseType()
    {
        return $this->belongsTo(ExerciseType::class, 'exercise_type_id');
    }

    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'exercise_muscle', 'exercise_id', 'muscle_id');
    }

    // Definir la relación con el modelo Routine
    // public function routines()
    // {
    //     return $this->belongsToMany(Routine::class, 'routine_exercise');
    // }
}
