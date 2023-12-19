<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {

        $credentials = $request->validated();

        if (!$this->guard()->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 422);
        }

        $this->guard()->attempt($credentials);
        $token = $this->guard()->user()->createToken('auth-token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $this->guard()->user(),
            'message' => 'Authorized',
        ], 200);
    }

    public function destroy(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $this->guard()->logout();
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function guard($guard = 'web')
    {
        return Auth::guard($guard);
    }
}
