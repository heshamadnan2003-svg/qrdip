<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $fillable = [
        'organization_id',
        'date',
        'start_time',
        'end_time',
        'reason'
    ];
}

