<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function attendances() {
      return $this->hasMany('App\Programatt');
    }
}
