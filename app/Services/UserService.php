<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function register(String $username, String $password, String $email): User
    {
        $user = User::create([
            'username'  => $username,
            'password'  => Hash::make($password),
            'email'     => $email,
        ]);

        return $user;
    }
}