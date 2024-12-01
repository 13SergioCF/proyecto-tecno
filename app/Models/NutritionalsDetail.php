<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NutritionalsDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nutritionals_details';

    protected $fillable = [
        'id_alimento',
        'id_nutriente',
        'cantidad_calorias',
    ];

    public function aliment()
    {
        return $this->belongsTo(Aliment::class, 'id_alimento');
    }

    public function nutrient()
    {
        return $this->belongsTo(Nutrient::class, 'id_nutriente');
    }
}
