<?php

namespace App;

use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Channel extends Model implements HasMedia
{
    use HasMediaTrait;

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function image() {
        return $this->media->first()->getFullUrl('thumb');
    }

    public function editable() {
        if (!auth()->check()) return false;
        return $this->user_id === auth()->user()->id;
    }

    public function registerMediaConversions(?Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }
}
