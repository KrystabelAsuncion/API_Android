<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        // Create a new user
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Generate access token for the newly registered user
        $accessToken = $user->createToken('PinoySpecials')->accessToken;

        return response()->json([
            'status' => 'success',
            'data' => $user,
            'access_token' => $accessToken,
        ]);
    }

    public function all(Request $request)
    {
        $user = User::all();
        return response()->json([
            'status' => true,
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('PinoySpecials')->accessToken; // Generate token
            return response()->json([
                'status' => true,
                'message' => 'user found',
                'access_token' => $token, // Send token in the response
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed'
            ], 401);
        }
    }
}
