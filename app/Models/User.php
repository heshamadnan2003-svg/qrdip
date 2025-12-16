<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // تعريف الأدوار
    const ROLES = [
        'admin' => 'مشرف',
        'organization' => 'جهة منظمة',
        'user' => 'مستخدم عادي'
    ];

    // دوال التحقق من الدور
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isOrganization()
    {
        return $this->role === 'organization';
    }

    public function isRegularUser()
    {
        return $this->role === 'user';
    }

    // العلاقة مع الجهة (إذا كان جهة منظمة)
    public function organization()
    {
        return $this->hasOne(\App\Models\Organization::class);
    }
}