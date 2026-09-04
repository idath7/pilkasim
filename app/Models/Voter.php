<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voter extends Model
{
    protected $fillable = [
        'type',
        'nis',
        'name',
        'class_name',
        'gender',
        'access_code',
        'username',
        'password',
        'has_voted',
        'voted_candidate_id',
    ];
}
