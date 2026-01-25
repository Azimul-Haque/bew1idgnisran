<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $with = ['area', 'center'];

    public function area() {
        return $this->belongsTo(Area::class);
    }

    public function center() {
        return $this->belongsTo(Center::class);
    }
}
