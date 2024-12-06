<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayThunder extends Model
{
    use HasFactory;

    protected $table = 'days_thunders';

    protected $fillable = [
        'id_dia',
        'id_turno',
    ];

    public function day()
    {
        return $this->belongsTo(Day::class, 'id_dia');
    }

    public function details()
    {
        return $this->hasMany(DetailsDaysThunder::class, 'id_day_thunder');
    }
}
