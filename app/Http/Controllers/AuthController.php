<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        $user = Auth::check();
        if (!$user) return response()->json([
            'message' => 'Unauthenticated',
        ], 401);

        return response()->json([
            "message" => "Success",
            "data" => Auth::user()
        ], 200);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            "password" => "required"
        ]);

        if ($validator->fails()) return response()->json(['message' => $validator->errors()->first()], 422);

        if (Auth::attempt(['username' => $request->username, "password" => $request->password])) {
            $user = Auth::user();
            $user->token = $user->createToken(Str::random(50))->plainTextToken;
            return response()->json(["message" => "Login Success", "data" => $user]);
        }
        return response()->json(['message' => "Wrong Username or Password "], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken->delete();
    }
}
