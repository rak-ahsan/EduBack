<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);


            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('Personal Access Token')->plainTextToken;
                return response()->json([
                    'status' => 1,
                    'message' => 'Logged in successfully',
                    'user' => $user,
                    'token' => $token,
                ])->cookie('auth_token', $token, 1000, '/', 'localhost', true, true);

            }

            return response()->json([
                'status' => 0,
                'message' => 'Invalid credentials',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'An error occurred while trying to log in',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
