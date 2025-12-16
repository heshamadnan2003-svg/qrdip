<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
    'organization_id',
    'name',
    'price',
    'duration',
];



}
