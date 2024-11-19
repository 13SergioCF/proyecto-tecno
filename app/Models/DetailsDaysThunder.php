<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsDaysThunder extends Model
{
    use HasFactory;

    // Definir la tabla para esta clase
    protected $table = 'details_days_thunders';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_day_thunder', 
        'id_diet_aliment',
    ];

    // Relación con la tabla 'days_thunders'
    public function dayThunder()
    {
        return $this->belongsTo(DayThunder::class, 'id_day_thunder');
    }

    // Relación con la tabla 'diets_aliments'
    public function dietAliment()
    {
        return $this->belongsTo(DietsAliment::class, 'id_diet_aliment');
    }
}
