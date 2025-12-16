<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

/* Public */
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationController;

/* User */
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\ProviderApplyController;

/* Manager */
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\ServiceController as ManagerServiceController;
use App\Http\Controllers\Manager\TimeSlotController as ManagerTimeSlotController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::view('/about', 'about');
Route::view('/contact', 'contact');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Home (after login)
|--------------------------------------------------------------------------
*/
Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| User Area
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/user/home', [UserHomeController::class, 'index'])
        ->name('user.home');

    Route::get('/user/bookings', [BookingController::class, 'index'])
        ->name('user.bookings');

    /*
    | Provider (الحلاق) Apply
    */
    Route::get('/provider/apply', [ProviderApplyController::class, 'create'])
        ->name('provider.apply');

    Route::post('/provider/apply', [ProviderApplyController::class, 'store'])
        ->name('provider.apply.store');
});

/*
|--------------------------------------------------------------------------
| Manager Area
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('manager')->name('manager.')->group(function () {

    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/services', [ManagerServiceController::class, 'index'])
        ->name('services');

    // 🟢 جديد
    Route::post('/services', [ManagerServiceController::class, 'store'])
        ->name('services.store');
});


/*
|--------------------------------------------------------------------------
| Public Organization Page (QR destination)
|--------------------------------------------------------------------------
| ⚠️ مهم: خارج auth و group
*/
Route::get('/org/{slug}', [OrganizationController::class, 'show'])
    ->name('organization.show');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
