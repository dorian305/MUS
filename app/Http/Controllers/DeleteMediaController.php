<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteMediaRequest;
use Illuminate\Http\JsonResponse;

use App\Services\MediaService;

class DeleteMediaController extends Controller
{
    private $media_service;

    public function __construct(MediaService $media_service)
    {
        $this->media_service = $media_service;
    }

    public function index(DeleteMediaRequest $request): JsonResponse
    {
        $id = $request->input("id");
        $deleted_media = $this->media_service->delete($id);
        $response = [
            'data' => [
                'message' => "File with the id {$id} deleted.",
                'file'    => $deleted_media,
            ],
            'status_code' => 200,
        ];

        return new JsonResponse($response['data'], $response['status_code']);
    }
}
