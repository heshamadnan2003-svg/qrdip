<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * عرض جميع المستخدمين
     */
    public function index()
    {
        $users = User::with('organization.reviews')
            ->orderBy('role')
            ->latest()
            ->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * تفعيل / تعطيل المستخدم
     */
    public function toggleStatus(User $user)
{
    if ($user->role === 'admin') {
        return back();
    }

    $user->is_active = ! $user->is_active;
    $user->save();

    return back()->with('success', __('messages.status_updated'));
}


    /**
     * حذف مستخدم
     */
    public function destroy(User $user)
    {
        // منع حذف الأدمن
        if ($user->role === 'admin') {
            return back();
        }

        $user->delete();

        return back()->with('success', __('messages.user_deleted'));
    }

    /**
     * عرض تفاصيل المدير
     */
    public function show(User $user)
    {
        if ($user->role !== 'manager') {
            abort(404);
        }

        $user->load([
            'organization',
            'organization.services',
            'organization.bookings.service',
        ]);

        return view('admin.users.show', compact('user'));
    }

    /* ===================== ADD ADMIN ===================== */

    /**
     * صفحة إنشاء أدمن
     */
    public function createAdmin()
    {
        return view('admin.users.create-admin');
    }

    /**
     * حفظ أدمن جديد
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', __('messages.admin_created_successfully'));
    }

    /* ===================== BOOKINGS (اختياري) ===================== */

    public function blockCustomer(Booking $booking)
    {
        $booking->update([
            'status' => 'blocked',
        ]);

        return back()->with('success', __('messages.customer_blocked'));
    }

    public function deleteCustomer(Booking $booking)
    {
        $booking->delete();

        return back()->with('success', __('messages.customer_deleted'));
    }
}
