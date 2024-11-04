<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'question_types';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $dates = ['deleted_at'];
    public function question()
    {
        return $this->hasMany(Question::class);
    }
}
