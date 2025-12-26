<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    use HasFactory;

  protected $fillable = [
    'organization_id',
    'day_of_week', // ✅ نفس الاسم في الجدول والكنترولر
    'start_time',
    'end_time',
    'is_active',
];


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
