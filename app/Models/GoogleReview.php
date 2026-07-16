<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    protected $guarded = [];

    protected $casts = [
        'rating' => 'integer',
        'published_at' => 'datetime',
        'is_active' => 'boolean',
        'raw_payload' => 'array',
    ];
}
