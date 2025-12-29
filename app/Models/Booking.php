<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
    'organization_id',
    'service_id',
    'booking_date',
    'start_time',
    'end_time',
    'customer_name',
    'customer_phone',
    'customer_email',
    'customer_address',
    'status',
];

public function organization()
{
    return $this->belongsTo(\App\Models\Organization::class);
}

public function service()
{
    return $this->belongsTo(\App\Models\Service::class);
}

public function review()
{
    return $this->hasOne(\App\Models\Review::class);
}


}
