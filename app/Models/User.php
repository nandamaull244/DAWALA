<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\HashIdTrait;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HashIdTrait;

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
        'created_at',
        'updated_at',
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

    public function instanceUsers()
    {
        return $this->hasMany(InstanceUsers::class, 'user_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'user_id', 'id');
    }
}
