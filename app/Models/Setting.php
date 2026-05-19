<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'team_members' => 'array',
        'payment_methods' => 'array',
        'social_links' => 'array',
        'theme_settings' => 'array',
    ];
}
