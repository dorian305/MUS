<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;

use App\Services\UserService;

class UserController extends Controller
{
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function register(UserRegisterRequest $request): JsonResponse
    {
        $request_data = $request->all();
        $user = $this->user_service->register(
            $request_data['username'],
            $request_data['password'],
            $request_data['email'],
        );

        $response = [
            'data' => [
                'message' => "Registration success.",
                'user' => $user,
            ],
            'status_code' => 200,
        ];

        return new JsonResponse($response['data'], $response['status_code']);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $request_data = $request->all();
        $login_data = $this->user_service->login(
            $request_data["identifier"],
            $request_data["password"]
        );

        $response = [
            'data' => [
                'message' => "Logged in.",
                'user' => $login_data['user'],
                'token' => [
                    'type' => "Bearer",
                    'token' => $login_data['token']->plainTextToken,
                ]
            ],
            'status_code' => 200,
        ];
        
        return new JsonResponse($response['data'], $response['status_code']);
    }
}
