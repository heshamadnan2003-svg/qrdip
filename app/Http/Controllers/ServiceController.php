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

        if (!$organization) {
            abort(403, 'لا يوجد لديك مؤسسة مرتبطة');
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
            abort(403, 'لا يوجد لديك مؤسسة مرتبطة');
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
}
