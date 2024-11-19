<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietsAliment extends Model
{
    use HasFactory;

    // Definir la tabla, ya que no sigue la convención de pluralización
    protected $table = 'diets_aliments';

    // Los campos que se pueden asignar masivamente
    protected $fillable = [
        'id_dieta',
        'id_alimento',
    ];

    // Relación con la tabla 'diets' (una dieta puede tener muchos alimentos)
    public function diet()
    {
        return $this->belongsTo(Diet::class, 'id_dieta');
    }

    // Relación con la tabla 'aliments' (un alimento puede pertenecer a muchas dietas)
    public function aliment()
    {
        return $this->belongsTo(Aliment::class, 'id_alimento');
    }
}
