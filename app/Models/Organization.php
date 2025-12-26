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
        'unique_hash',
    ];

    protected $casts = [
        'settings'  => 'array',
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($organization) {
            if (empty($organization->slug)) {
                $organization->slug = Str::slug($organization->name);
            }

            if (empty($organization->unique_hash)) {
                $organization->unique_hash = Str::random(32);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // صاحب النشاط (المدير)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // الخدمات
    public function services()
{
    return $this->hasMany(\App\Models\Service::class);
}


    // أوقات الدوام
   public function workingHours()
{
    return $this->hasMany(WorkingHour::class);
}


    // أيام العطل
    public function daysOff()
    {
        return $this->hasMany(DayOff::class);
    }

    // الأوقات المحظورة
    public function blockedTimes()
    {
        return $this->hasMany(BlockedTime::class);
    }

    // الحجوزات
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // رابط صفحة الحجز العامة (QR)
    public function bookingUrl()
    {
        return route('organization.show', $this->slug);
    }

    public function holidays()
{
    return $this->hasMany(Holiday::class);
}

public function times($slug, $serviceId)
{
    $organization = Organization::where('slug', $slug)->firstOrFail();

    $service = $organization->services()
        ->where('id', $serviceId)
        ->firstOrFail();

    // لاحقًا سنجلب الأوقات المتاحة هنا
    return view('organization.times', compact('organization', 'service'));
}
public function busyTimes()
{
    return $this->hasMany(BusyTime::class);
}


}
