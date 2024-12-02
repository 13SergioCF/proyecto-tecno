<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationJson extends Model
{
    use HasFactory;

    protected $table = 'recommendation_json';

    protected $fillable = [
        'recommendation_id',
        'content_json',
    ];

    protected $casts = [
        'content_json' => 'array',
    ];
}
