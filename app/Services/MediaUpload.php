<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaUpload
{
    private Array $response = [];
    public static function uploadFile(UploadedFile $file, String $uploadDir, Array $allowedFileTypes) : Array
    {
        try {
            // Upload file to the storage
            $baseUrl = request()->getSchemeAndHttpHost();
            $filePath = Storage::disk('local')->putFile($uploadDir, $file);

            $fullPath = "{$baseUrl}/storage/{$filePath}";

            $response['success'] = true;
            $response['fullPath'] = $fullPath;
        }

        catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = "An error occured while trying to upload the file: {$e->getMessage()}";
        }

        return $response;
    }
}