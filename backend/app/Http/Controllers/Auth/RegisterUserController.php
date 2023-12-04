<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserRegisterRequest $request)
    {        
        $payload = $request->validated();
        $payload['password'] = Hash::make($payload['password']);
        $payload['email_verified_at'] = now()->toISOString();

        $user = User::create($payload);
        event(new Registered($user));
        Auth::login($user);
    }
}
