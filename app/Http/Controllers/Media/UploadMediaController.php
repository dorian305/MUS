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
        // Invalid api key provided.
        if (!$this->api_key_service->validate($request->user(), $request->input("apiKey"))){
            $response = [
                'data'          =>  ['message' => "Invalid api key provided."],
                'status_code'   =>  403,
            ];

            return new JsonResponse($response['data'], $response['status_code']);
        }

        // Upload the files.
        $response = $this->media_service->uploadFiles($request->file("files"), $request->input("user_id"));

        return new JsonResponse($response['data'], $response['status_code']);
    }
}