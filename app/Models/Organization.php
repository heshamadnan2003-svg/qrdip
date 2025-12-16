<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'category',
        'logo',
        'contact_email',
        'contact_phone',
        'address',
        'settings',
        'is_active',
        'qr_code',
        'unique_hash'
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    // إنشاء slug و hash تلقائياً
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            $organization->slug = Str::slug($organization->name);
            $organization->unique_hash = Str::random(32);
        });
    }

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // دوال مساعدة
    public function getBookingPageUrl()
    {
        return route('booking.page', $this->unique_hash);
    }
}