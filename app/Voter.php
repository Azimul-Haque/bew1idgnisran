<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = [
        'union_municipality', 'ward', 'area_name', 'area_no', 
        'gender', 'serial', 'voter_no', 'name', 
        'father', 'mother', 'dob', 'occupation', 'address'
    ];
}
