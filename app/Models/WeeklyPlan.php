<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nutritional_plan_id',
        'week_number',
        'start_date',
        'end_date',
        'period',
    ];

    public function nutritionalPlan()
    {
        return $this->belongsTo(NutritionalPlan::class, 'nutritional_plan_id');
    }

    public function dailyPlanDetails()
    {
        return $this->hasMany(DailyPlanDetail::class, 'weekly_plan_id');
    }
}
