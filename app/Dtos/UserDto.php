<?php

namespace App\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class UserDto extends DataTransferObject
{
    public string $username;

    public string $email;

    public string $password;
}
