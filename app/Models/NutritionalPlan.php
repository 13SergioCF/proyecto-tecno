<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NutritionalPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'description', 'plan_type'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function diets()
    {
        return $this->hasMany(Diet::class, 'nutritional_plan_id');
    }

    public function exercisePlans()
    {
        return $this->hasMany(ExercisePlan::class, 'nutritional_plan_id');
    }

    public function weeklyPlans()
    {
        return $this->hasMany(WeeklyPlan::class, 'nutritional_plan_id');
    }

    public function userActivePlans()
    {
        return $this->hasMany(UserActivePlan::class, 'nutritional_plan_id');
    }
}
