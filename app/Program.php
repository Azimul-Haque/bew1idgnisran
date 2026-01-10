<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    public function attendances() {
        // সরাসরি ক্লাস ব্যবহার করা স্ট্রিং ব্যবহারের চেয়ে ভালো
        return $this->hasMany(\App\Models\Programatt::class, 'program_id');
    }
}
