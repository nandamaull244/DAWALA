<?php

namespace App\Traits;

trait HashIdTrait
{
    public function getHashedId()
    {
        return hash('sha256', $this->id . config('app.key'));
    }

    public static function findByHash($hash)
    {
        foreach (static::all() as $model) {
            if ($model->getHashedId() === $hash) {
                return $model;
            }
        }
        return null;
    }

    public static function decodeHash($hash)
    {
        foreach (static::all() as $model) {
            if ($model->getHashedId() === $hash) {
                return $model->id;
            }
        }
        return null;
    }

    public function scopeWhereHash($query, $hash)
    {
        $id = static::decodeHash($hash);
        return $query->where('id', $id);
    }
}
