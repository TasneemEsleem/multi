<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
use \Illuminate\Support\Str;


class RestPasswordController extends Controller
{
    public function index()
    {
        return response()->view('auth.forgetpassword');
    }
    public function ForgetPassword(Request $request)
    {
        $request->validate(['email' => 'email|required']);
        $email = User::where('email', $request->get('email'))->first();
        if ($email != null) {
            $status = Password::sendResetLink($request->only('email'));
            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => $status], Response::HTTP_OK)
                : response()->json(['message' => $status], Response::HTTP_BAD_REQUEST);
        }
    }
    public function showResetPassword(Request $request, $token)
    {
        return response()->view('auth.reset_password', ['token' => $token,
         'email' => $request->input('email')]);
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:3|confirmed',
        ]);
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
                    $user->save();
                    event(new PasswordReset($user));
                }
            );
            return $status === Password::PASSWORD_RESET
                ? response()->json(['message' => __($status)], Response::HTTP_OK)
                : response()->json(['message' => __($status)], Response::HTTP_BAD_REQUEST);

    }
}
