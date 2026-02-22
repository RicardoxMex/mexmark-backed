<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class RegisterController extends Controller
{
    /**
     * Handle a registration request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Crear token para el usuario
        $token = $user->createToken('auth-token')->plainTextToken;
        $minutes = config('session.lifetime');
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
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201)->withCookie($cookie);
    }
}
