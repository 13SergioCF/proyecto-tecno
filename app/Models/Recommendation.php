<?php

namespace App\Models;

use App\Events\RecommendationCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recommendation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'content', 'content_json'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::created(function ($recommendation) {
            event(new RecommendationCreated($recommendation));
        });
    }
}
