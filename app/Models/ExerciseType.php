<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExerciseType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exercise_types';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $dates = ['deleted_at'];
    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'exercise_type_id');
    }
}
