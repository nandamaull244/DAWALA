<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'username',
        'password',
        'full_name',
        'birth_date',
        'gender', // Enum: ['Laki-Laki', 'Perempuan']
        'no_kk',
        'username',
        'email',
        'phone_number',
        'district_id',
        'village_id',
        'rt',
        'rw',
        'address',
        'role', // Enum: ['admin', 'operator', 'user', 'instantiation']
        'registration_type',
        'registration_status', // Enum: ['Process', 'Rejected', 'Completed']
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

    public function instance()
    {
        return $this->hasOne(Instance::class, 'user_id', 'id');
}
}
