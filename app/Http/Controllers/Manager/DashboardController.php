<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use Carbon\Carbon;


class DashboardController extends Controller
{
    /**
     * عرض لوحة تحكم المدير
     */


public function index()
{
    $user = auth()->user();

    // جلب جهة المدير
    $organization = $user->organization;

    if (!$organization) {
        return view('manager.dashboard', compact('organization'));
    }

    $today = Carbon::today();
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek = Carbon::now()->endOfWeek();
    $startOfMonth = Carbon::now()->startOfMonth();

    $stats = [
        // حجوزات اليوم
        'today' => Booking::where('organization_id', $organization->id)
            ->whereDate('booking_date', $today)
            ->where('status', 'confirmed')
            ->count(),

        // حجوزات هذا الأسبوع
        'week' => Booking::where('organization_id', $organization->id)
            ->whereBetween('booking_date', [$startOfWeek, $endOfWeek])
            ->where('status', 'confirmed')
            ->count(),

        // حجوزات هذا الشهر
        'month' => Booking::where('organization_id', $organization->id)
            ->whereDate('booking_date', '>=', $startOfMonth)
            ->where('status', 'confirmed')
            ->count(),

        // الحجوزات الملغاة
        'cancelled' => Booking::where('organization_id', $organization->id)
            ->where('status', 'cancelled')
            ->count(),

        // الحجوزات القادمة
        'upcoming' => Booking::where('organization_id', $organization->id)
            ->whereDate('booking_date', '>=', $today)
            ->where('status', 'confirmed')
            ->count(),
    ];

    return view('manager.dashboard', compact('organization', 'stats'));
}




    /**
     * إعادة توليد QR Code للجهة
     */
    public function regenerateQr()
    {
        $organization = auth()->user()->organization;

        if (!$organization) {
            return redirect()->back()->withErrors([
                'msg' => 'لا توجد جهة مرتبطة بهذا الحساب'
            ]);
        }

        // رابط الصفحة العامة
        $publicUrl = url('/org/' . $organization->slug);

        // مسار حفظ QR
        $qrPath = 'qrcodes/org_' . $organization->id . '.png';

        // توليد QR
        QrCode::format('svg')
            ->size(300)
            ->generate($publicUrl, storage_path('app/public/' . $qrPath));

        // حفظ المسار في قاعدة البيانات
        $organization->qr_code = $qrPath;
        $organization->save();

        return redirect()->back()->with('success', 'تم إنشاء QR Code بنجاح');
    }
}
