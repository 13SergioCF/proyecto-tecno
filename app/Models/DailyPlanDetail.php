<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyPlanDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'weekly_plan_id',
        'day',
        'plan_type',
        'diet_id',
        'exercise_id',
        'exercise_duration_minutes',
        'quantity',
    ];

    public function weeklyPlan()
    {
        return $this->belongsTo(WeeklyPlan::class, 'weekly_plan_id');
    }

    public function diet()
    {
        return $this->belongsTo(Diet::class, 'diet_id');
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
