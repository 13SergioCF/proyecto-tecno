<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayThunder extends Model
{
    use HasFactory;

    protected $table = 'days_thunders';

    // Indica que la tabla no tiene un campo 'id' incremental
    public $incrementing = false;

    // Define los campos asignables
    protected $fillable = ['id_dia', 'id_turno'];

    // Relaciones
    public function day()
    {
        return $this->belongsTo(Day::class, 'id_dia', 'id_dia');
    }

    public function thunder()
    {
        return $this->belongsTo(Thunder::class, 'id_turno', 'id_turno');
    }
}
