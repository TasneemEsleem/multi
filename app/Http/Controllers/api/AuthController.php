<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomException;
use App\Mail\UserForgetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($request->only(['email', 'password']))) {
            $user = Auth::user();
            $token = $user->createToken('token-name', ['server:update'])->plainTextToken;
            return CustomException::validMessage([
                'message' => 'Login Successfully',
                'token' => $token,
                'user' => $user,
            ]);
        }
        return CustomException::errorMessage(
            'Invalid credentials',
            500
        );
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->tokens->each(function ($token, $key) {
                $token->delete();
            });
            return CustomException::validMessage('logout_success', Response::HTTP_OK);
        } else {
            return CustomException::errorMessage(
                'Something Went Wrong',
                500
            );
        }
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password:',
            'new_password' => ['required', 'confirmed', Password::min(8)],
        ]);
        $user = $request->user();
        $user->forceFill(['password' => Hash::make($request->input('new_password'))]);
        $user->save();

        return CustomException::validMessage('Updated successfully', Response::HTTP_OK);
    }

    public function ForgetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['email' => 'email|required|exists:users,email']
        );

        if ($validator->fails()) {
            return CustomException::errorMessage('Validation failed', Response::HTTP_BAD_REQUEST, $validator->errors());
        }
        $user = User::where('email', $request->get('email'))->first();
        $code = random_int(1000, 9999);
        $user->verification_code = Hash::make($code);
        if ($user->save()) {
            Mail::to($user)->send(new UserForgetPasswordEmail($user, $code));
            return CustomException::validMessage('Send Code To change Password Successfully', Response::HTTP_OK);
        } else {
            return CustomException::errorMessage(
                'Send Code To change Password Failed',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'email|required|exists:users,email',
                'code' => 'required|numeric|digits:4',
                'new_password' => 'required|confirmed|min:8',
            ]
        );
        if ($validator->fails()) {
            return CustomException::errorMessage('Validation failed', Response::HTTP_BAD_REQUEST, $validator->errors());
        }
        $user = User::where('email', '=', $request->get('email'))->first();
        if (Hash::check($request->input('code'), $user->verification_code)) {
            $user->forceFill(['password' => Hash::make($request->input('new_password'))]);
            $user->save();
            return CustomException::validMessage('Reset Password successfully', Response::HTTP_OK);
        } else {
            return CustomException::errorMessage(
                'Send Code To change Password Failed',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
