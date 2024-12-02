<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'diets';
    protected $fillable = [
        'descripcion',
        'tipo',
        'id_periodo',
        'nutritional_plan_id',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'id_periodo');
    }

    public function nutritionalPlan()
    {
        return $this->belongsTo(NutritionalPlan::class, 'nutritional_plan_id');
    }

    public function aliments()
    {
        return $this->belongsToMany(Aliment::class, 'diets_aliments', 'id_dieta', 'id_alimento');
    }


    public function dailyPlanDetails()
    {
        return $this->hasMany(DailyPlanDetail::class, 'diet_id');
    }
}
