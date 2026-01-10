<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function attendances(): HasMany
    {
        return $this->hasMany(ProgramAttendance::class);
    }
}
