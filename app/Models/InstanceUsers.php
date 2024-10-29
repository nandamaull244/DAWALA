<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstanceUsers extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "instance_users";
    protected $fillable = ['instance_id', 'user_id', 'name', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function instance()
    {
        return $this->belongsTo(Instance::class, 'instance_id', 'id');
    }
}
