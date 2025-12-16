<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController; // أضف هذا

// Routes للتسجيل (لدينا RegisterController مخصص)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    
    // صفحات بسيطة مؤقتاً
    Route::get('login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Routes بعد الدخول - استخدم DashboardController
Route::middleware('auth')->group(function () {
    // استخدم DashboardController بدلاً من Closure
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::post('logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

// احذف أو علّق هذا القسم المكرر:
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');