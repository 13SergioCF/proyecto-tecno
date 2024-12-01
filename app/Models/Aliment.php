<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aliment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'descripcion', 'estado', 'food_type_id', 'imagen_url', 'video_url'];

    public function foodType()
    {
        return $this->belongsTo(FoodType::class, 'food_type_id');
    }
    public function nutritionalsDetails()
    {
        return $this->hasMany(NutritionalsDetail::class, 'id_alimento');
    }

    public function diets()
    {
        return $this->belongsToMany(Diet::class, 'diets_aliments', 'id_alimento', 'id_dieta');
    }
}
