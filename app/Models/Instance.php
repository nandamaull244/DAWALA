<?php

namespace App\Models;

use App\Models\User;
use App\Models\InstanceUsers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "instances";
    protected $fillable = ['user_id', 'name', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function instanceUsers()
    {
        return $this->hasMany(InstanceUsers::class, 'instance_id', 'id');
    }
}
