<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ServiceImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "service_images";
    protected $fillable = ['service_id', 'image_type', 'image_path', 'original_name', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
