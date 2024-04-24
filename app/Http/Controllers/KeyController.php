<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Services\ApiKeyService;

class KeyController extends Controller
{
    public function index(Request $request)
    {
        $api_key = ApiKeyService::get($request->ip());

        return new JsonResponse(
            data: ['api_key' => $api_key],
            status: 200,
        );
    }
}
