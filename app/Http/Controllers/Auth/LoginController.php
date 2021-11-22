<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

/**
 * @group Auth
 */
class LoginController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Log in
     *
     * @param LoginRequest $request
     * @return UserResource
     *
     * @bodyParam email email required The email of the user. Example: user@test.com
     * @bodyParam password string required User password. Example: superSecretPassword8
     *
     * @response scenario=success {
     *  "id": "bb5c27e8-8832-40c7-a279-8ff071ec6b25",
     *  "username": "petra",
     *  "token": "5|9aGMoXfs5MyvBUR9Jv9sHD2ko21VHfpeKyhqIGHN"
     *  }
     *
     * @response status=500 scenario="Wrong credentials" { "message": "Invalid credentials"}
     */
    public function __invoke(LoginRequest $request)
    {
        $user = $this->userService->getUserByEmail($request->email);
        if (!$user || !Hash::check($request->password, $user->password)) {
           throw new UnauthorizedException('Invalid credentials');
        }
        $user->token =$user->createToken('access_token')->plainTextToken;

        return new UserResource($user);
    }
}
