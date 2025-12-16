<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{
    /**
     * عرض لوحة تحكم المدير
     */
    public function index()
    {
        $organization = auth()->user()->organization;

        return view('manager.dashboard', compact('organization'));
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
        $publicUrl = url('/o/' . $organization->slug);

        // مسار حفظ QR
        $qrPath = 'qrcodes/org_' . $organization->id . '.png';

        // توليد QR
        QrCode::format('png')
            ->size(300)
            ->generate($publicUrl, storage_path('app/public/' . $qrPath));

        // حفظ المسار في قاعدة البيانات
        $organization->qr_code = $qrPath;
        $organization->save();

        return redirect()->back()->with('success', 'تم إنشاء QR Code بنجاح');
    }
}
