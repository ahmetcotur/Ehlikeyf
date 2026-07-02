<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    protected $casts = [
        'booking_date' => 'date',
        'party_size' => 'integer',
    ];
}
