<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $organization = Auth::user()->organization;

        // لو المستخدم لا يملك منظمة
        if (!$organization) {
            return redirect()
                ->route('manager.dashboard')
                ->with('error', 'يجب إنشاء منشأة أولاً');
        }

        $services = Service::where('organization_id', $organization->id)->get();

        return view('manager.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric',
            'duration' => 'required|integer',
        ]);

        $organization = Auth::user()->organization;

        if (!$organization) {
            return redirect()->back()->withErrors('لا توجد منشأة مرتبطة بهذا الحساب');
        }

        Service::create([
            'organization_id' => $organization->id,
            'name'            => $request->name,
            'price'           => $request->price,
            'duration'        => $request->duration,
        ]);

        return redirect()
            ->route('manager.services')
            ->with('success', 'تمت إضافة الخدمة بنجاح');
    }
    public function update(Request $request, Service $service)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'price'    => 'required|numeric|min:0',
        'duration' => 'required|integer|min:1',
    ]);

    // حماية: التأكد أن الخدمة للمدير نفسه
    abort_if(
        $service->organization_id !== auth()->user()->organization->id,
        403
    );

    $service->update([
        'name'     => $request->name,
        'price'    => $request->price,
        'duration' => $request->duration,
    ]);

    return back()->with('success', 'تم تحديث الخدمة بنجاح');
}

public function destroy(Service $service)
{
    abort_if(
        $service->organization_id !== auth()->user()->organization->id,
        403
    );

    $service->delete();

    return back()->with('success', 'تم حذف الخدمة بنجاح');
}

}
