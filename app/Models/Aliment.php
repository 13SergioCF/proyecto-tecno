<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aliment extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'estado', 'food_type_id'];

    // Relación: Un alimento pertenece a un tipo de alimento
    public function foodType()
    {
        return $this->belongsTo(FoodType::class, 'food_type_id');
    }
}
