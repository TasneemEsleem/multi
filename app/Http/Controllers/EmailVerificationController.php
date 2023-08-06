<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return response()->view('auth.verify-email');
    }
    public function send(Request $request)
    {
        if (!$request->user()->hasVerifiedEmail()) {
            $request->user()->sendEmailVerificationNotification();
            return response()->json(['message' => 'Verification email sent successfully'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'Your account has been verified!'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function verify(EmailVerificationRequest $emailVerificationRequest)
    {
        $emailVerificationRequest->fulfill();
        return redirect()->route('dashboard');
    }
}
