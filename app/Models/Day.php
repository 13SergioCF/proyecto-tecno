<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Day extends Model
{
    use HasFactory;

    protected $table = 'days';

    protected $fillable = [
        'nombre',
    ];

    public function thunders()
    {
        return $this->hasMany(DayThunder::class, 'id_dia');
    }
}
