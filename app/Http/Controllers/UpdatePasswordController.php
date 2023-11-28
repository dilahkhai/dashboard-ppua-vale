<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    public function index()
    {
        return view('update-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (Hash::check($request->old_password, Auth::user()->password)) {
            Auth::user()->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('success', 'Password updated!');
        }

        return back()->with('fail', 'Failed, Old password wrong!');
    }
}
