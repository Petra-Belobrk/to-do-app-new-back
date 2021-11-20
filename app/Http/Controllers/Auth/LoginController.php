<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;

class LoginController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the incoming request.
     *
     * @param LoginRequest $request
     * @return UserResource
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
