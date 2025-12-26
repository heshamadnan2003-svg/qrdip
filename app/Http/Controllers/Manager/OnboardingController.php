<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Service;
use App\Models\WorkingHour;
use Illuminate\Support\Facades\DB;



class OnboardingController extends Controller
{
    /**
     * تأكد أن المستخدم داخل Onboarding فعّال
     */
   public function __construct()
{
    $this->middleware(function ($request, $next) {

        $user = auth()->user();

        // ❌ لا onboarding + لا منظمة → ممنوع
        if (!session('onboarding.active') && !$user->organization) {
            return redirect('/home');
        }

        return $next($request);
    });
}


    /**
     * خطوة معلومات الشركة
     */
    public function company()
{
    $organization = auth()->user()->organization;

    return view('manager.onboarding.company', compact('organization'));
}


 
public function storeCompany(Request $request)
{
    $request->validate([
        'name'          => 'required|string|max:255',
        'description'   => 'nullable|string',
        'category' => $request->category,
        'contact_phone' => 'required|string|max:50',
        'contact_email' => 'required|email',
        'address'       => 'required|string',
    ]);

    $user = auth()->user();

    $organization = Organization::updateOrCreate(
        ['user_id' => $user->id],
        [
            'name'          => $request->name,
            'description'   => $request->description,
            'category'      => $request->category,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'address'       => $request->address,
        ]
    );

    session(['onboarding.last_completed_step' => 'company']);

    return redirect()
        ->route('manager.dashboard')
        ->with('success', __('messages.success_saved'));
}



    /**
     * خطوة الخدمات
     */
    public function services()
    {
        // حماية: لا يمكن دخول الخدمات بدون إكمال الشركة
        if (session('onboarding.last_completed_step') !== 'company') {
            return redirect()->route('manager.onboarding.company');
        }

        return view('manager.onboarding.services');
    }

    public function storeServices(Request $request)
    {
        $request->validate([
            'services' => 'required|array|min:1',
            'services.*.name' => 'required|string',
            'services.*.price' => 'required|numeric',
            'services.*.duration' => 'required|integer',
        ]);

        session([
            'onboarding.services' => $request->services,
            'onboarding.last_completed_step' => 'services',
        ]);

        return redirect()->route('manager.onboarding.working-hours');
    }

    /**
     * خطوة أوقات الدوام
     */
    public function workingHours()
    {
        // حماية: لا يمكن دخول الدوام بدون إكمال الخدمات
        if (session('onboarding.last_completed_step') !== 'services') {
            return redirect()->route('manager.onboarding.services');
        }

        return view('manager.onboarding.working-hours');
    }

    /**
     * إكمال الـ Onboarding وإنشاء الشركة فعليًا
     */
    public function complete(Request $request)
    {
        $request->validate([
            'working_hours' => 'required|array|min:1',
        ]);

        session([
            'onboarding.working_hours' => $request->working_hours,
            'onboarding.last_completed_step' => 'working-hours',
        ]);

        DB::transaction(function () {

            $company  = session('onboarding.company');
            $services = session('onboarding.services');
            $hours    = session('onboarding.working_hours');

            // إنشاء الشركة
            $organization = Organization::create([
                'user_id' => auth()->id(),
                'name' => $company['name'],
                'description' => $company['description'] ?? null,
            ]);

            // إنشاء الخدمات
            foreach ($services as $service) {
                Service::create([
                    'organization_id' => $organization->id,
                    'name' => $service['name'],
                    'price' => $service['price'],
                    'duration' => $service['duration'],
                ]);
            }

            // إنشاء أوقات الدوام
            foreach ($hours as $day) {
                if (!empty($day['start_time']) && !empty($day['end_time'])) {
                    WorkingHour::create([
                        'organization_id' => $organization->id,
                        'day_of_week' => $day['day_of_week'],
                        'start_time' => $day['start_time'],
                        'end_time' => $day['end_time'],
                    ]);
                }
            }

            // ❗ إيقاف الـ onboarding نهائيًا
            session()->forget('onboarding');
            session()->forget('onboarding.active');
        });

        return redirect()->route('manager.dashboard')
            ->with('success', '🎉 تم إنشاء شركتك بنجاح');
    }

    public function show()
{
    $organization = auth()->user()->organization;

    return view('manager.onboarding.company', compact('organization'));
}

}
