<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashIdTrait;

class Service extends Model
{
    use HasFactory, SoftDeletes, HashIdTrait;

    protected $table = "services";
    protected $fillable = ['user_id', 'ticket', 'service_list_id', 'reason', 'latitude', 'longitude', 'service_type', 'service_category', 'service_status', 'message_for_user', 'working_status', 'visit_schedule', 'document_recieved_status', 'rejected_reason', 'created_at', 'approval_by', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function approvalBy()
    {
        return $this->belongsTo(User::class, 'approval_by', 'id');
    }

    public function service_list()
    {
        return $this->belongsTo(ServiceList::class, 'service_list_id');
    }

    public function service_image()
    {
        return $this->hasMany(ServiceImage::class, 'service_id');
    }

    public function service_form()
    {
        return $this->hasMany(ServiceForm::class, 'service_id');
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['user', 'service_image', 'service_form', 'user.district', 'user.village']);
    }

    public static function findByHashWithRelations($hashedId)
    {
        return static::withRelations()->where('id', static::decodeHash($hashedId))->first();
    }
}
