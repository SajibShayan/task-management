<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->authenticate();
        $request->session()->regenerate();

        return response()->json(['message' => 'Authenticated'], 200);
    }
}
