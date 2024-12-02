<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'apellido_paterno',
        'apellido_materno',
        'genero',
        'fecha_nacimiento',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }
    public function medicalDetails()
    {
        return $this->hasMany(MedicalDetail::class);
    }
    // public function muscles()
    // {
    //     return $this->belongsToMany(Muscle::class, 'user_muscles', 'user_id', 'muscle_id')
    //         ->withTimestamps();
    // }
    public function nutritionalPlans()
    {
        return $this->hasMany(NutritionalPlan::class, 'user_id');
    }

    public function userActivePlans()
    {
        return $this->hasMany(UserActivePlan::class, 'user_id');
    }
    // public function muscles()
    // {
    //     return $this->belongsToMany(Muscle::class, 'user_muscles', 'user_id', 'muscle_id')
    //         ->withTimestamps();
    // }

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class, 'user_id');
    }

    public function muscles()
    {
        return $this->belongsToMany(Muscle::class, 'user_muscles');
    }
}
