<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Responses\AuthResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthResponse;
    /* 
        register user 
    */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);
        if (!auth()->attempt($validatedData)) {
            return $this->failRegister($validatedData, 'fail to register', 422);
        }
        $validatedData['password'] = bcrypt($request->password);
        $user = User::create($validatedData);
        $accessToken = $user->createToken('authToken')->accessToken;
        return $this->successRegister($user, 'successfully register', 201, $accessToken);
    }

    /* 
        login user
    */
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        if (!auth()->attempt($validatedData)) {
            return $this->failLogin($validatedData, 'user did not exitst', 400);
        }
        Auth::user();
        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        return $this->successLogin($validatedData, 'successfully login', 201, $accessToken);
    }   
}
