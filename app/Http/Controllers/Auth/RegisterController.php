<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomException;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('landingPage.register');
    }
    public function register(Request $request, CustomException  $customException)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string']
        ]);
        try {
            if ($validator->fails()) {
                return CustomException::errorMessage('An error occurred while registering', Response::HTTP_BAD_REQUEST, $validator->errors());
            }
            $user_saved = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_type' => 4
            ]);
            event(new Registered($user_saved));
            return $customException->validMessage('Registration completed successfully!',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return CustomException::errorMessage('An error occurred while registering',
             Response::HTTP_INTERNAL_SERVER_ERROR , $e->getMessage());
        }
    }
}
