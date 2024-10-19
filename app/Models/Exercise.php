<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{

    use HasFactory, SoftDeletes;

       protected $fillable = [
        'name',
        'description',
        'category',
        'duration',
        'calories_burned',
    ];

}
