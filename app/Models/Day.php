<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    // Definir la tabla si el nombre no sigue la convención (en este caso, 'days')
    protected $table = 'days';

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'nombre',
    ];

    // Definir la clave primaria si no es 'id'
    protected $primaryKey = 'id_dia';

    // Si la clave primaria no es un auto-incremento, puedes agregar:
    // public $incrementing = false;
}
