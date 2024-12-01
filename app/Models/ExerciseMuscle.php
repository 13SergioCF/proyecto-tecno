<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExerciseMuscle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exercise_muscle'; // Nombre de la tabla

    protected $fillable = [
        'exercise_id',
        'muscle_id',
        'intensidad',
    ];

    // Relación con Exercise
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    // Relación con Muscle
    public function muscle()
    {
        return $this->belongsTo(Muscle::class);
    }
    public function exerciseType()
    {
        return $this->belongsTo(ExerciseType::class, 'exercise_type_id');
    }
}
