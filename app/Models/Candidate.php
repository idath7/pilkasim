<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'name',
        'class_name',
        'organization',
        'vision',
        'mission',
        'photo',
        'votes',
    ];
}
