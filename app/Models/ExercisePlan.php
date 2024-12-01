<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExercisePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nutritional_plan_id',
        'exercise_id',
        'frequency_per_week',
        'duration_minutes',
        'customized',
    ];

    /**
     * Relación con el modelo NutritionalPlan.
     */
    public function nutritionalPlan()
    {
        return $this->belongsTo(NutritionalPlan::class, 'nutritional_plan_id');
    }

    /**
     * Relación con el modelo Exercise.
     */
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
