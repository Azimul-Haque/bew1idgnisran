<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function council() {
        return $this->belongsTo(Council::class);
    }
    
    public function voters() {
        return $this->hasMany(Voter::class);
    }
}
