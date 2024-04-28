<?php

namespace App\Services;

use App\Models\Media;

use Exception;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;


class MediaService
{
    public function uploadFiles($uploaded_files): Array
    {
        $files = [];
        $upload_dir = Config::get("upload.directory");
        $allowed_file_types = [
            "jpeg", "jpg", "png", "gif", // Image extensions
            "mp4", "avi", "mov", "mkv",  // Video extensions
        ];

        // Unsupported file type.
        foreach ($uploaded_files as $uploaded_file){
            $file_name = $uploaded_file->getClientOriginalName();
            $file_type = explode("/", $uploaded_file->getMimeType())[1];

            if (!in_array($file_type, $allowed_file_types)){
                return [
                    'data' => [
                        'message' => "Unsupported file type.",
                        'file' => [
                            'name' => $file_name,
                            'type' => $file_type,
                        ],
                    ],
                    'status_code' => 403,
                ];
            }
        }

        foreach ($uploaded_files as $uploaded_file){
            // Get information about the file.
            $file_name = $uploaded_file->getClientOriginalName();
            $file_type = explode("/", $uploaded_file->getMimeType())[1];
            $file_size = $uploaded_file->getSize(); // Size is in bytes

            // Upload the file.
            try {
                $base_url       = request()->getSchemeAndHttpHost();
                $relative_path  = Storage::disk('local')->putFile($upload_dir, $uploaded_file);
                $full_path      = "{$base_url}/storage/{$relative_path}";

                array_push($files, [
                    'name' => explode("/", $relative_path)[1], // Extract unique file name from upload_dir/unique_file_name
                    'type' => $file_type,
                    'size' => $file_size,
                    'path' => $full_path,
                ]);
            }

            catch (Exception $e){
                return [
                    'data' => [
                        'message' => "An error occured while trying to upload the file: {$e->getMessage()}",
                        'file' => [
                            'name' => $file_name,
                            'type' => $file_type,
                        ],
                    ],
                    'status_code' => 500,
                ];
            }
        }

        // Bulk insert file records into table.
        Media::insert($files);

        return [
            'data' => [
                'message'   => "Files uploaded.",
                'files'     => $files,
            ],
            'status_code' => 200,
        ];
    }

    public function delete(Int $id): Media
    {
        $media = Media::find($id);
        
        // Delete stored file.
        $upload_dir = Config::get("upload.directory");
        Storage::delete("{$upload_dir}/{$media->name}");

        // Delete record from table.
        $media->delete();

        return $media;
    }

    public function mediaExists(Int $id): Bool
    {
        return Media::where("id", $id)
                    ->exists();
    }
}