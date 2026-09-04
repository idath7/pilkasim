<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'school_name',
        'instructions',
        'osim_logo',
        'school_logo',
        'main_image',
        'theme_color_1',
        'theme_color_2',
        'theme_color_3',
        'theme_color_4',
        'theme_color_5',
        'theme_color_6',
        'use_gradient',
        'token_duration',
        'login_method',
        'voting_start_time',
        'voting_end_time',
        'timezone',
        'kiosk_pin',
    ];

    protected $casts = [
        'voting_start_time' => 'datetime',
        'voting_end_time' => 'datetime',
    ];
}
