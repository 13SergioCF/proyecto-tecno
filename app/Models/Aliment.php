<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aliment extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'estado', 'food_type_id', 'imagen_url', 'video_url'];

    public function foodType()
    {
        return $this->belongsTo(FoodType::class);
    }


    public function nutrients()
    {
        return $this->belongsToMany(Nutrient::class, 'nutritionals_details')
            ->withPivot('cantidad_calorias');
    }
}
