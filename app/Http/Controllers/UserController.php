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
            'email' => 'required',
            'password' => 'required',
        ]);
        $user = User::create($validatedData);

        return response()->json([
            'status' => 'success',
            'data' => $user
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

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'user found',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Authentication failed'
            ], 401);
        }
    }
}
