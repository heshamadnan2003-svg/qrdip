<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show register form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => 'manager',
    ]);
}


protected function redirectTo()
{
    if (auth()->user()->role === 'manager') {
        session(['onboarding.active' => true]);
        return route('manager.onboarding.company');
    }

    return '/home';
}



    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'manager', // مهم
        ]);

        Auth::login($user);

        return redirect()->route('user.home');
    }

    protected function registered(Request $request, $user)
{
    // لو المستخدم مدير
    if ($user->role === 'manager') {

        // تفعيل onboarding
        session([
            'onboarding.active' => true,
        ]);

        return redirect()->route('manager.onboarding.company');
    }

    // غير ذلك (user / admin)
    return redirect('/home');
}

}
