<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'questions';

    /**
     * Atributos asignables en la tabla.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'contenido',
        'question_type_id',
        'estado'
    ];

    /**
     * Relación con el modelo QuestionType.
     * Una pregunta pertenece a un tipo de pregunta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function questionType()
    {
        return $this->belongsTo(QuestionType::class);
    }

    // /**
    //  * Relación con el modelo Answer.
    //  * Una pregunta puede tener múltiples respuestas.
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\HasMany
    //  */
    // public function answers()
    // {
    //     return $this->hasMany(Answer::class);
    // }
}
