<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function __invoke(LoginRequest $request)
    {
        $request->authenticate();

        $user = Auth::user();

        // Crear token para el usuario
        $token = $user->createToken('auth-token')->plainTextToken;

        $minutes = $request->boolean('remember') ? 60 * 24 * 30 : config('session.lifetime');
        $cookie = new Cookie(
            'auth_token',
            $token,
            now()->addMinutes($minutes),
            config('session.path', '/'),
            config('session.domain'),
            (bool) config('session.secure'),
            true,
            false,
            config('session.same_site', 'lax')
        );

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ])->withCookie($cookie);
    }
}
