<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "service_forms";
    protected $fillable = ['service_id', 'form_type', 'form_path', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
}
