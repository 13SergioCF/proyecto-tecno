<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_answers';
    protected $fillable = ['user_id', 'question_id', 'respuesta_json'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
