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
        return static::all()->first(function ($model) use ($hash) {
            return $model->getHashedId() === $hash;
        });
    }
}
