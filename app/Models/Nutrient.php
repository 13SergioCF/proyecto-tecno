<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nutrient extends Model
{
    use HasFactory;
    protected $table = 'nutrients';

    protected $fillable = ['nombre', 'descripcion', 'estado'];

    // Filtrar solo los registros activos
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
    public function aliments()
    {
        return $this->belongsToMany(Aliment::class, 'nutritionals_details')
            ->withPivot('cantidad_calorias');
    }
}
