<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;

use App\Services\ApiKeyService;
use App\Http\Requests\UploadPostRequest;
use App\Services\MediaUploadService;

class UploadController extends Controller
{
    public function index(UploadPostRequest $request) : JsonResponse
    {
        // Store all data from the request body.
        // Check the custom request for info on what data is stored.
        $request_body = $request->all();

        // Invalid api key provided.
        if (!ApiKeyService::validate($request->ip(), $request_body['apiKey'])){
            $response = [
                'data'          =>  ['message' => "Invalid key provided."],
                'status_code'   =>  403,
            ];

            return new JsonResponse($response['data'], $response['status_code']);
        }

        // Upload the files files.
        $response = MediaUploadService::uploadFiles($request->file("files"));

        return new JsonResponse($response['data'], $response['status_code']);
    }
}