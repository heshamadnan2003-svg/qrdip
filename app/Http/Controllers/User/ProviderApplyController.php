<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProviderApplyController extends Controller
{
    public function create()
    {
        // إذا كان لديه منظمة بالفعل
        if (Auth::user()->organization) {
            return redirect()
                ->route('manager.dashboard')
                ->with('error', 'لديك جهة مسجلة بالفعل');
        }

        return view('provider.apply');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // حماية إضافية
        if ($user->organization) {
            return redirect()
                ->route('manager.dashboard')
                ->with('error', 'لديك جهة مسجلة بالفعل');
        }

        // التحقق من البيانات
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'category'      => 'required|string|max:255',
            'description'   => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string|max:20',
            'address'       => 'required|string|max:255',
        ]);

        // إنشاء slug
        $data['slug'] = Str::slug($data['name']);
        $data['user_id'] = $user->id;
        $data['is_active'] = true;

        // حفظ المنظمة
        Organization::create($data);

        return redirect()
            ->route('manager.dashboard')
            ->with('success', 'تم إنشاء صفحتك بنجاح 🎉');
    }
}
