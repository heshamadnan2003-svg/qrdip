<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    /**
     * إنشاء منظمة (أول مرة)
     */
    public function create()
    {
        return view('manager.organization.create');
    }

    /**
     * حفظ منظمة جديدة
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category'       => 'required|string|max:255',
            'contact_phone'  => 'required|string|max:50',
            'contact_email'  => 'required|email|max:255',
            'address'        => 'required|string|max:255',
        ]);

        $organization = Organization::create([
            'user_id'        => auth()->id(),
            'name'           => $request->name,
            'description'    => $request->description,
            'category'       => $request->category,
            'contact_phone'  => $request->contact_phone,
            'contact_email'  => $request->contact_email,
            'address'        => $request->address,
            'is_active'      => true,
        ]);

        // توليد QR Code
        $this->generateQrCode($organization);

        return redirect()
            ->route('manager.dashboard')
            ->with('success', __('messages.success_saved'));
    }

    /**
     * ✏️ صفحة تعديل معلومات المنظمة
     */
    public function edit()
    {
        $organization = auth()->user()->organization;

        abort_if(!$organization, 404);

        return view('manager.organization.edit', compact('organization'));
    }

    /**
     * 💾 تحديث معلومات المنظمة
     */
    public function update(Request $request)
    {
        $organization = auth()->user()->organization;

        abort_if(!$organization, 404);

        $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'category'       => 'required|string|max:255',
            'contact_phone'  => 'required|string|max:50',
            'contact_email'  => 'required|email|max:255',
            'address'        => 'required|string|max:255',
        ]);

        $organization->update($request->only([
            'name',
            'description',
            'category',
            'contact_phone',
            'contact_email',
            'address',
        ]));

        return redirect()
            ->route('manager.dashboard')
            ->with('success', __('messages.success_saved'));
    }

    /**
     * 🔹 توليد QR Code (دالة مشتركة)
     */
    private function generateQrCode(Organization $organization)
    {
        $url  = route('org.show', $organization->slug);
        $path = 'qrcodes/org_' . $organization->id . '.svg';

        QrCode::format('svg')
            ->size(300)
            ->generate($url, storage_path('app/public/' . $path));

        $organization->update([
            'qr_code' => 'storage/' . $path
        ]);
    }
}
