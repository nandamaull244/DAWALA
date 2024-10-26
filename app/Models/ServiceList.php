<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceList extends Model
{
    use HasFactory;

    protected $table = "service_list";
    protected $fillable = ['service_name', 'service_description'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
