<?php

namespace App\Responses;

trait ResponseFormat
{
    public function apiSuccessResponse($data, $message, $statusCode = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => true,
            'code' => $statusCode,
        ], $statusCode);;
    }
    public function apiErrorResponse($data = null, $message, $statusCode = 500)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => false,
            'code' => $statusCode,
        ], $statusCode);
    }
    public function apiValidationErrorResponse($data = null, $message, $errors = [], $statusCode = 422)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'success' => false,
            'code' => $statusCode,
            'errors' => $errors
        ], $statusCode);
    }
    public function apiNoAuth($message, $statusCode = 500)
    {
        return response()->json([
            'message' => $message,
            'code' => $statusCode
        ]);
    }
}
