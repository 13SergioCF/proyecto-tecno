<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;

    // Definir la tabla si el nombre no sigue la convención (plural de la clase)
    protected $table = 'diets';

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'descripcion',
        'tipo',
        'id_periodo'
    ];

    // Relación con la tabla 'periods' (un periodo puede tener muchas dietas)
    public function Period()
    {
        return $this->belongsTo(Period::class, 'id_periodo');
    }



}
