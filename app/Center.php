<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    public function voters() {
        return $this->hasMany(Voter::class);
    }
}
