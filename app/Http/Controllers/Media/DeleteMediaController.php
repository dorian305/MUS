<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Services\MediaService;

use App\Http\Controllers\Controller;

class DeleteMediaController extends Controller
{
    private $media_service;

    public function __construct(MediaService $media_service)
    {
        $this->media_service = $media_service;
    }

    public function delete(Request $request, Int $id): JsonResponse
    {
        if (!$this->media_service->mediaExists($id)){
            return new JsonResponse(['message' => "Media with id: {$id} does not exist."], 404);
        }

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
