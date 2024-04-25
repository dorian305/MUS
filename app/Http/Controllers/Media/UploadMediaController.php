<?php

namespace App\Http\Controllers\Media;


use Illuminate\Http\JsonResponse;

use App\Services\ApiKeyService;
use App\Services\MediaService;

use App\Http\Controllers\Controller;

use App\Http\Requests\UploadMediaRequest;

class UploadMediaController extends Controller
{
    private $api_key_service;
    private $media_service;

    public function __construct(ApiKeyService $api_key_service, MediaService $media_service)
    {
        $this->api_key_service = $api_key_service;
        $this->media_service = $media_service;
    }

    public function index(UploadMediaRequest $request) : JsonResponse
    {
        // Store all data from the request body.
        // Check the custom request for info on what data is stored.
        $request_body = $request->all();

        // Invalid api key provided.
        if (!$this->api_key_service->validate($request->ip(), $request_body['apiKey'])){
            $response = [
                'data'          =>  ['message' => "Invalid key provided."],
                'status_code'   =>  403,
            ];

            return new JsonResponse($response['data'], $response['status_code']);
        }

        // Upload the files files.
        $response = $this->media_service->uploadFiles($request->file("files"));

        return new JsonResponse($response['data'], $response['status_code']);
    }
}