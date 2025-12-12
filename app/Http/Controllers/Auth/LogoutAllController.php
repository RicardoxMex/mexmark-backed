<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutAllController extends Controller
{
    /**
     * Revoke all tokens for the authenticated user.
     */
    public function __invoke(Request $request)
    {
        // Revocar todos los tokens del usuario
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'All sessions logged out successfully',
        ]);
    }
}