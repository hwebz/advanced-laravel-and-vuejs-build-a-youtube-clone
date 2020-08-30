<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    // art migrate:fresh
    public $incrementing = false;

    protected $guarded = [];

    protected static function boot() {
        parent::boot();
        static::creating(function($model) {
            // $model->id = Str::uuid();
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
}
