<?php

namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;

class UserService
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(UserDto $userDto): User
    {
        return $this->model->create($userDto->all());
    }

    public function getUserByEmail(string $email): User|null
    {
        return $this->model->where('email', $email)->first();
    }
}
