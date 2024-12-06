<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailsDaysThunder extends Model
{
    use HasFactory;

    protected $table = 'details_days_thunders';

    protected $fillable = [
        'id_day_thunder',
        'id_diet_aliment',
    ];

    public function dayThunder()
    {
        return $this->belongsTo(DayThunder::class, 'id_day_thunder');
    }
}
