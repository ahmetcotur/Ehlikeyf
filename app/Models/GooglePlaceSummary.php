<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GooglePlaceSummary extends Model
{
    protected $guarded = [];

    protected $casts = [
        'rating' => 'float',
        'review_count' => 'integer',
        'raw_payload' => 'array',
        'synced_at' => 'datetime',
    ];
}
