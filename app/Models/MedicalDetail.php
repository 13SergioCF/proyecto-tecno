<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalDetail extends Model
{
    use HasFactory, SoftDeletes;

    // Tabla asociada
    protected $table = 'medical_details';

    // Campos que se pueden asignar en masa
    protected $fillable = [
        'user_id',
        'enfermedad_base',
        'alergia_alimento',
    ];

    /**
     * Relación: cada detalle médico pertenece a un usuario.
     */  public function user()
    {
        return $this->belongsTo(User::class);
    }
}
