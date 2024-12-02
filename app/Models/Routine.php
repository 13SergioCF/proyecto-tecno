<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Routine extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Campos asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'nivel',
        'duracion_estimada',
        'objetivo',
        'frecuencia_semanal',
        'estado',
        'exercise_id',
    ];

    /**
     * Los atributos que deberían ser casteados.
     *
     * @var array
     */
    protected $casts = [
        'nivel' => 'string',
        'estado' => 'string',
        'duracion_estimada' => 'integer',
        'frecuencia_semanal' => 'integer',
    ];
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'routine_exercise');
    }
}
