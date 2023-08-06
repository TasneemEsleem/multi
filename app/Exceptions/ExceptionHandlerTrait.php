<?php

namespace App\Exceptions;
use Exception;
use Symfony\Component\HttpFoundation\Response;

trait ExceptionHandlerTrait
{
private function handleException(Exception $e)
    {
        if ($e instanceof CustomException1) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } elseif ($e instanceof CustomException2) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(['error' => 'An error occurred.'.$e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

// Custom exception classes
class CustomException1 extends Exception
{
    protected $message = 'Page Not Found Please Insert the corect route';
}

class CustomException2 extends Exception
{
    protected $message = 'Bad Request';
}

?>
