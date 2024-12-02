<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    use HasFactory;
    protected $table = 'food_types';

    protected $fillable = ['nombre', 'descripcion', 'estado'];

    // Filtrar solo los registros activos

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
    public function aliments()
    {
        return $this->hasMany(Aliment::class, 'food_type_id');
    }
}
