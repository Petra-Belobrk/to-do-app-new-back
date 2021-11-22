<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

/**
 * @group Auth
 */
class LogoutController extends Controller
{
    /**
     * Logout
     *
     * @return JsonResponse
     * @authenticated
     *
     * @response scenario=success { "ok" }
     * @response status=401 scenario="wrong token" { "message": "Unauthenticated."}
     */
    public function __invoke(): JsonResponse
    {
        $user = auth()->user();
        $user->tokens()->delete();

        return response()->json('ok');
    }
}
