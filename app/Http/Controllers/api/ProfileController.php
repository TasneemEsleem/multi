<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomException;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    public function editProfile(Request $request)
    {
    $request->validate([
            'name' => ['sometimes', 'nullable', 'string', 'min:3'],
            'email' => ['sometimes', 'required', 'email'],
        ]);
        try {
            $user = auth()->user();
            if ($request->has('name') && $request->input('name') !== '') {
                $user->name = $request->input('name');
            }
            if ($request->has('email') && $request->input('email') !== '') {
                $user->email = $request->input('email');
            }
            $isSaved = $user->save();
            return CustomException::validMessage(
                ['message' => 'Successfully Update Profile'],
                'completed successfully!',
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            return CustomException::errorMessage('An error occurred while Update Profile'
                . $e->getMessage(), 500);
        }
    }
}
