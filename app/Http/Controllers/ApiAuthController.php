<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        if ($credentials->fails()) {
            return response()->json($credentials->errors(), 400);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        return response()->json(["message" => "User created!"], 202);
    }

    public function login(Request $request)
    {
        $credentials = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($credentials->fails()) {
            return response()->json($credentials->errors(), 400);
        }


        $user = User::where('email', $request->email)->first();

        if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response([
                'user' => $user,
                'accessToken' => $user->createToken('accessToken', [$user->role === 'admin' ? 'admin' : 'user'])->plainTextToken
            ]);
        }

        return response(["message" => "Invalid authentication credentials"], 401);
    }
}
