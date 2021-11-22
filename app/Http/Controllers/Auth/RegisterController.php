<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @group Auth
 */
class RegisterController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam username string required Username of user. Example: Admin
     * @bodyParam email email required User password. Example: test@user.com
     * @bodyParam password string required User password. Example: superSecretPassword8
     * @bodyParam password_confirmation string required Confirm user password. Example: superSecretPassword8
     *
     * @response scenario=success { "User created" }
     * @response status=422 scenario="Validation error" {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *      "username": [
     *          "The username has already been taken."
     *       ],
     *      "email": [
     *          "The email field is required."
     *          ]
     *      }
     *   }
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $this->userService->create($request->dto());
        return response()->json('User Created', 201);
    }
}
