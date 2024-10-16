<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InstantiationUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "instantiation_users";
    protected $fillable = ['instantiation_id', 'user_id', 'name', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
