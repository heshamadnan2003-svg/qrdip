<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ApplyController extends Controller
{
    public function create()
    {
        return view('provider.apply');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        $organization = Organization::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'category' => $request->category,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'address' => $request->address,
            'unique_hash' => Str::uuid(),
        ]);

        // ترقية المستخدم إلى manager
        $user = Auth::user();
        $user->role = 'manager';
        $user->save();

        return redirect()->route('manager.dashboard');
    }
}
