<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HashIdTrait;

class Article extends Model
{
    use HasFactory, SoftDeletes, HashIdTrait;

    protected $table = "articles";
    protected $fillable = ['user_id', 'slug', 'title', 'body', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
