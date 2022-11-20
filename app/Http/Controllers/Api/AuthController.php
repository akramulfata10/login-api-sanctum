<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    // public function tes() {
    //     $user = User::latest()->get();

    //     return response()->json([
    //         'data' => $user,
    //         'token_type' => 'Bearer',
    //     ]);
    // }

    public function register(Request $request) {
        $validateData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validateData->fails()) {
            return response()->json($validateData->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request) {
        if (Auth::attempt($request->only($request->email, $request->password))) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => "success login",
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request) {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success',
        ]);
    }

}