<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nutritional_plan_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function nutritionalPlan()
    {
        return $this->belongsTo(NutritionalPlan::class, 'nutritional_plan_id');
    }
}
