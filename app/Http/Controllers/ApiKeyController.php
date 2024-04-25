<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\ApiKeyService;

class ApiKeyController extends Controller
{
    private $apiKeyService;

    public function __construct(ApiKeyService $apiKeyService)
    {
        $this->apiKeyService = $apiKeyService;
    }

    public function index(Request $request)
    {
        $api_key = $this->apiKeyService->get($request->ip());

        return new JsonResponse(
            data: ['api_key' => $api_key],
            status: 200,
        );
    }
}
