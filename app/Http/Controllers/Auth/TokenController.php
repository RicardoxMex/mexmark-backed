<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Get all tokens for the authenticated user.
     */
    public function index(Request $request)
    {
        $tokens = $request->user()->tokens()->get(['id', 'name', 'last_used_at', 'created_at']);

        return response()->json([
            'tokens' => $tokens,
        ]);
    }

    /**
     * Revoke a specific token.
     */
    public function destroy(Request $request, $tokenId)
    {
        $token = $request->user()->tokens()->where('id', $tokenId)->first();

        if (!$token) {
            return response()->json([
                'message' => 'Token not found.',
            ], 404);
        }

        $token->delete();

        return response()->json([
            'message' => 'Token revoked successfully.',
        ]);
    }
}