<?php
namespace App\Http\Controllers;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class CustomException {

    public static function validMessage($data = null, $message = null, $statusCode = Response::HTTP_OK)
    {
        $response = [
            'status' => 'success',
            'data' => $data,
        ];
        if ($message !== null) {
            $response['message'] = $message;
        }

        return response()->json($response, $statusCode);
    }
    public static function errorMessage($message = null,
     $statusCode = Response::HTTP_BAD_REQUEST
     , $errors = null)
    {
        $response = [
            'status' => 'error',
            'message' => $message ?: 'An error occurred.',
        ];
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        return response()->json($response, $statusCode);
    }
}

   ?>
