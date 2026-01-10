<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function programatts() {
      return $this->hasMany('App\Programatt');
    }
}
