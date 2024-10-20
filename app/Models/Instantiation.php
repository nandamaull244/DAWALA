<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instantiation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "instantiations";
    protected $fillable = ['user_id', 'name', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
