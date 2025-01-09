<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->token = $user->currentAccessToken()->name;
        return response()->json([
            "message" => "Success",
            "data" => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            "password" => "required"
        ]);

        if ($validator->fails()) return response()->json(['message' => $validator->errors()->first()], 422);

        $user = User::where('username', $request->username)->first();
        if (!$user) {
            return response()->json([
                'message' => "User not found"
            ], 404);
        }

        if ($user && Hash::check($request->password, $user->password)) {
            $user->token = $user->createToken(Str::random(50))->plainTextToken;
            return response()->json(["message" => "Login Success", "data" => $user]);
        }
        return response()->json(['message' => "Wrong Username or Password "], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "message" => "Logout Success"
        ]);
    }
}
