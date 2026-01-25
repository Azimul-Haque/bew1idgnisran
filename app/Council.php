<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
    public function areas() {
        return $this->hasMany(Area::class);
    }
}
