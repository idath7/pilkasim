<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = [
        'nis',
        'name',
        'class_name',
        'gender',
        'access_code',
        'has_voted',
    ];
}
