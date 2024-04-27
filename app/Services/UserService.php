<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function loggedIn(String $identifier): Bool
    {
        $id = User::where("username", $identifier)
                    ->orWhere("email", $identifier)
                    ->pluck("id");

        return DB::table("personal_access_tokens")
                    ->where("tokenable_id", $id)
                    ->exists();
    }

    public function register(
        String $username,
        String $password,
        String $password_confirmation,
        String $email
    ): User
    {
        $user = User::create([
            'username'  => $username,
            'password'  => Hash::make($password),
            'email'     => $email,
        ]);

        return $user;
    }

    public function login(String $identifier, String $password): Array
    {
        $user = User::where("username", $identifier)
                    ->orWhere("email", $identifier)
                    ->first();

        $data = [
            'user'  => $user,
            'token' => $user->createToken($identifier),
        ];

        return $data;
    }

    public function logout(Int $id): void
    {
        $user = User::where("id", $id)
                    ->first();

        $user->tokens()->delete();
    }
}