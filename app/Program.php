<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function attendees() {
        // সরাসরি ক্লাস ব্যবহার করা স্ট্রিং ব্যবহারের চেয়ে ভালো
        return $this->hasMany('App\Programatt', 'program_id');
    }
}
