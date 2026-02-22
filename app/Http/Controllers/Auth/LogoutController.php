<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Cookie;

class LogoutController extends Controller
{
    /**
     * Handle a logout request.
     */
    public function __invoke(Request $request)
    {
        // Revocar el token actual del usuario
        $currentToken = $request->user()->currentAccessToken();

        if ($currentToken) {
            $currentToken->delete();
        } else {
            $plainTextToken = $request->cookie('auth_token');
            $accessToken = $plainTextToken ? PersonalAccessToken::findToken($plainTextToken) : null;
            $accessToken?->delete();
        }

        return response()->json([
            'message' => 'Logout successful',
        ])->withCookie(Cookie::create('auth_token')->withValue('')->withExpires(1));
    }
}
