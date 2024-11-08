<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $table = 'periods';

    protected $fillable = ['fecha_inicio', 'fecha_final', 'estado'];

    // Filtrar solo los registros activos
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
