<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'Phone'   => 'nullable|digits_between:8,15',
            'Address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'Phone'   => $request->Phone,
            'Address' => $request->Address,
        ]);

        return back()->with('success', 'Profile updated successfully');
    }

}
