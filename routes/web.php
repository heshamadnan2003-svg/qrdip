<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\Admin\AdminUserController;

// Customer (Authenticated)
use App\Http\Controllers\User\HomeController as UserHomeController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\ProviderApplyController;
use App\Http\Controllers\User\ReviewController;

// Public (QR - Guest)
use App\Http\Controllers\PublicBookingController;

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
Route::view('/', 'welcome')->name('welcome');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| Authenticated Users (Customer)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/user/home', [UserHomeController::class, 'index'])
        ->name('user.home');

    /* ===== Customer Bookings ===== */
    Route::get('/my-bookings', [BookingController::class, 'index'])
        ->name('customer.bookings');

    Route::get('/my-bookings/{booking}/edit', [BookingController::class, 'edit'])
        ->name('customer.bookings.edit');

    Route::patch('/my-bookings/{booking}', [BookingController::class, 'update'])
        ->name('customer.bookings.update');

    Route::patch('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('customer.bookings.cancel');

    /* ===== Reviews ===== */
    Route::get('/reviews/{booking}/create', [ReviewController::class, 'create'])
        ->name('reviews.create');

    Route::post('/reviews/{booking}', [ReviewController::class, 'store'])
        ->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| Booking Flow (Public - Create Booking)
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

Route::view('/booking/success', 'booking.success')
    ->name('booking.success');

Route::get('/user/available-times', [BookingController::class, 'availableTimes'])
    ->name('user.available-times');

/*
|--------------------------------------------------------------------------
| Provider Apply (Authenticated)
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
| Manager Onboarding
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('manager/onboarding')
    ->name('manager.onboarding.')
    ->group(function () {

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
| Manager Area
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('manager')
    ->name('manager.')
    ->group(function () {

        Route::get('/dashboard', [ManagerDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/services', [ManagerServiceController::class, 'index'])
            ->name('services');

        Route::post('/services', [ManagerServiceController::class, 'store'])
            ->name('services.store');

        Route::put('/services/{service}', [ManagerServiceController::class, 'update'])
            ->name('services.update');

        Route::delete('/services/{service}', [ManagerServiceController::class, 'destroy'])
            ->name('services.destroy');

        Route::get('/working-hours', [WorkingHourController::class, 'index'])
            ->name('working-hours');

        Route::post('/working-hours', [WorkingHourController::class, 'store'])
            ->name('working-hours.store');

        Route::post('/busy-times', [BusyTimeController::class, 'store'])
            ->name('busy-times.store');

        Route::delete('/busy-times/{busyTime}', [BusyTimeController::class, 'destroy'])
            ->name('busy-times.destroy');

        Route::get('/bookings', [ManagerBookingController::class, 'index'])
            ->name('bookings');

        Route::post('/bookings/{booking}/complete', [ManagerBookingController::class, 'complete'])
            ->name('bookings.complete');

        Route::post('/bookings/{booking}/no-show', [ManagerBookingController::class, 'noShow'])
            ->name('bookings.noShow');

        Route::post('/bookings/{booking}/cancel', [ManagerBookingController::class, 'cancel'])
            ->name('bookings.cancel');
    });

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/users', [AdminUserController::class, 'index'])
            ->name('users.index');

        Route::patch('/users/{user}/toggle', [AdminUserController::class, 'toggleStatus'])
            ->name('users.toggle');

        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])
            ->name('users.destroy');

        Route::get('/users/{user}', [AdminUserController::class, 'show'])
            ->name('users.show');

        Route::get('/admins/create', [AdminUserController::class, 'createAdmin'])
            ->name('admins.create');

        Route::post('/admins', [AdminUserController::class, 'storeAdmin'])
            ->name('admins.store');

        Route::patch('/customers/{booking}/block', [AdminUserController::class, 'blockCustomer'])
            ->name('customers.block');

        Route::delete('/customers/{booking}', [AdminUserController::class, 'deleteCustomer'])
            ->name('customers.delete');
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
| Public Previous Bookings (QR - Guest)
|--------------------------------------------------------------------------
*/
Route::post('/public/bookings/lookup',
    [PublicBookingController::class, 'lookup']
)->name('public.bookings.lookup');

Route::get('/public/bookings/result',
    [PublicBookingController::class, 'result']
)->name('public.bookings.result');

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
