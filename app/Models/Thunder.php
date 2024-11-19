<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thunder extends Model
{
    use HasFactory;

    // Definir la tabla si el nombre no sigue la convención (en este caso, 'thunders')
    protected $table = 'thunders';

    // Definir la clave primaria personalizada
    protected $primaryKey = 'id_turno';

    // Si la clave primaria no es incremental, descomentar lo siguiente
    // public $incrementing = false;
    // protected $keyType = 'string';

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'nombre', // Campo 'nombre' que puede ser asignado masivamente
    ];

    // Definir relaciones u otros métodos si es necesario
}
