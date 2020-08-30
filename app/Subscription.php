<?php

namespace App;

class Subscription extends Model
{
    public function channel() {
        return $this->belongsTo(Channel::class);
    }
}
