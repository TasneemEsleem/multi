<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    function loginCustomer() {
        return response()->view('landingPage.login');

    }
    public function showLogin()
    {
        return response()->view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['message' => 'Login Successfully']);
        }
    }
    public function editPassword()
    {
        return response()->view('controlPanel.Edit-Password');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password:',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);
        $user = $request->user();
        $user->forceFill(['password' => Hash::make($request->input('new_password'))]);
         $user->save();

        return response()->json(['message' => 'Updated successfully']);
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
