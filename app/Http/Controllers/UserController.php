<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
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
            $request_data['passwrd'],
            $request_data['passwrd_confirmation'],
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

        // if ($this->user_service->loggedIn($request_data['identifier'])) {
        //     return new JsonResponse([
        //         'errors' => [
        //             'message' => ["Already logged in."],
        //         ],
        //     ], 409);
        // }

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

    public function logout(Request $request): JsonResponse
    {
        $this->user_service->logout($request->input("id"));

        $response_data = [
            'data' => [
                'message' => "Logged out.",
            ],
            'status_code' => 200,
        ];

        return new JsonResponse($response_data['data'], $response_data['status_code']);
    }
}
