<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionalsDetail extends Model
{
    use HasFactory;

    // Definir la tabla si el nombre no sigue la convención (en este caso, 'nutritionals_details')
    protected $table = 'nutritionals_details';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_alimento',
        'id_nutriente',
        'cantidad_calorias',
    ];

    // Definir la relación con la tabla 'aliments'
    public function aliment()
    {
        return $this->belongsTo(Aliment::class, 'id_alimento');
    }

    // Definir la relación con la tabla 'nutrients'
    public function nutrient()
    {
        return $this->belongsTo(Nutrient::class, 'id_nutriente');
    }
}
