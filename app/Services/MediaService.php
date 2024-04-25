<?php

namespace App\Services;

use App\Models\Media;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;


class MediaService
{
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

}