<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programatt extends Model
{
    protected $fillable = ['program_id', 'device_id', 'attendee_name'];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function program() {
      return $this->belongsTo('App\User');
    }
}
