<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationController;

// Customer
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\ProviderApplyController;

// Manager
use App\Http\Controllers\Manager\OnboardingController;
use App\Http\Controllers\Manager\DashboardController as ManagerDashboardController;
use App\Http\Controllers\Manager\ServiceController as ManagerServiceController;
use App\Http\Controllers\Manager\WorkingHourController;
use App\Http\Controllers\Manager\BookingController as ManagerBookingController;
use App\Http\Controllers\Manager\BusyTimeController;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'));
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
| Home
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/user/home', [UserHomeController::class, 'index'])
        ->name('user.home');

    // ✅ حجوزات الزبون (موحد)
    Route::get('/my-bookings', [BookingController::class, 'index'])
        ->name('customer.bookings');

    Route::patch('/my-bookings/{booking}/cancel',
        [BookingController::class, 'cancel']
    )->name('customer.bookings.cancel');

    Route::get('/my-bookings/{booking}/edit',
        [BookingController::class, 'edit']
    )->name('customer.bookings.edit');

    Route::patch('/my-bookings/{booking}',
        [BookingController::class, 'update']
    )->name('customer.bookings.update');
});

/*
|--------------------------------------------------------------------------
| Booking Flow (Customer)
|--------------------------------------------------------------------------
*/
Route::post('/booking/confirm', [BookingController::class, 'storeSession'])
    ->name('booking.confirm.post');

Route::get('/booking/confirm', function () {
    abort_unless(session()->has('booking'), 403);
    return view('booking.confirm');
})->name('booking.confirm');

Route::post('/booking/store', [BookingController::class, 'store'])
    ->name('booking.store');

Route::get('/booking/success', fn () => view('booking.success'))
    ->name('booking.success');

/*
|--------------------------------------------------------------------------
| Provider Apply
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/provider/apply', [ProviderApplyController::class, 'create'])
        ->name('provider.apply');

    Route::post('/provider/apply', [ProviderApplyController::class, 'store'])
        ->name('provider.apply.store');
});

/*
|--------------------------------------------------------------------------
| Manager Onboarding (إنشاء / تعديل الشركة)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('manager/onboarding')
    ->name('manager.onboarding.')
    ->group(function () {

        // ✅ نفس الصفحة للإنشاء والتعديل
        Route::get('/company', [OnboardingController::class, 'company'])
            ->name('company');

        Route::post('/company', [OnboardingController::class, 'storeCompany'])
            ->name('company.store');

        Route::get('/services', [OnboardingController::class, 'services'])
            ->name('services');

        Route::post('/services', [OnboardingController::class, 'storeServices'])
            ->name('services.store');

        Route::get('/working-hours', [OnboardingController::class, 'workingHours'])
            ->name('working-hours');

        Route::post('/complete', [OnboardingController::class, 'complete'])
            ->name('complete');
    });

/*
|--------------------------------------------------------------------------
| Manager Dashboard
|--------------------------------------------------------------------------

|--------------------------------------------------------------------------
| Manager Area
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {

        /* ================= Dashboard ================= */
        Route::get('/dashboard', [ManagerDashboardController::class, 'index'])
            ->name('dashboard');

        /* ================= Organization ================= */

        // ✏️ تعديل معلومات المنظمة
        Route::get('/organization/edit',
            [\App\Http\Controllers\Manager\OrganizationController::class, 'edit']
        )->name('organization.edit');

        Route::post('/organization/update',
            [\App\Http\Controllers\Manager\OrganizationController::class, 'update']
        )->name('organization.update');

        /* ================= Services ================= */
        Route::get('/services', [ManagerServiceController::class, 'index'])
            ->name('services');

        Route::post('/services', [ManagerServiceController::class, 'store'])
            ->name('services.store');

        Route::put('/services/{service}', [ManagerServiceController::class, 'update'])
            ->name('services.update');

        Route::delete('/services/{service}', [ManagerServiceController::class, 'destroy'])
            ->name('services.destroy');

        /* ================= Working Hours ================= */
        Route::get('/working-hours', [WorkingHourController::class, 'index'])
            ->name('working-hours');

        Route::post('/working-hours', [WorkingHourController::class, 'store'])
            ->name('working-hours.store');

        /* ================= Busy Times ================= */
        Route::post('/busy-times', [BusyTimeController::class, 'store'])
            ->name('busy-times.store');

        Route::delete('/busy-times/{busyTime}', [BusyTimeController::class, 'destroy'])
            ->name('busy-times.destroy');

        /* ================= Bookings ================= */
        Route::get('/bookings', [ManagerBookingController::class, 'index'])
            ->name('bookings');

        Route::post('/bookings/{booking}/cancel',
            [ManagerBookingController::class, 'cancel']
        )->name('bookings.cancel');
    });
/*
|--------------------------------------------------------------------------
| Public Organization (QR)
|--------------------------------------------------------------------------
*/
Route::get('/org/{slug}', [OrganizationController::class, 'show'])
    ->name('org.show');

Route::get('/org/{slug}/services', [OrganizationController::class, 'services'])
    ->name('org.services');

Route::get('/org/{slug}/services/{service}', [OrganizationController::class, 'times'])
    ->name('org.times');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))
            ->name('dashboard');
    });

/*
|--------------------------------------------------------------------------
| Language Switch
|--------------------------------------------------------------------------
*/
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
