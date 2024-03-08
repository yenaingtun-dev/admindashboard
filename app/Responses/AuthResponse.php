<?php 

namespace App\Responses;

trait AuthResponse
{
    public function successLogin($data, $message, $statusCode = 200, $accessToken,)
    {
        return response()->json([
            'data' => $data, 
            'message' => $message,
            'success' => true,
            'code' => $statusCode,
            'accessToken' => $accessToken,
        ], $statusCode);
    }

    public function failLogin($data = null, $message, $statusCode, $errors = [])
    {
        return response()->json([
            'data' => $data, 
            'message' => $message,
            'success' => false,
            'code' => $statusCode,
            'errors' => $errors,
        ], $statusCode);
    }

    public function successRegister($data, $message, $statusCode, $accessToken)
    {
        return response()->json([
            'data' => $data, 
            'message' => $message,
            'success' => true,
            'code' => $statusCode,
            'accessToken' => $accessToken,
        ], $statusCode);
    }

    public function failRegister($data = null, $message, $statusCode = 422, $errors = [])
    {
        return response()->json([
            'data' => $data, 
            'message' => $message,
            'success' => false,
            'code' => $statusCode,
            'errors' => $errors,
        ], $statusCode);
    }

    public function successLogout($data, $message, $statusCode = 200)
    {
        return response()->json([
            'data' => $data, 
            'message' => $message,
            'code' => $statusCode,
            'success' => true,
        ], $statusCode);
    }

    public function failLogout($message,$statusCode = 500) 
    {
        return response()->json([
            'message' => $message,
            'code' => $statusCode,
        ]);
    }

}