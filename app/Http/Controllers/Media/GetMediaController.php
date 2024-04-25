<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;

use App\Models\Media;
use App\Http\Resources\MediaResource;

use App\Http\Controllers\Controller;

class GetMediaController extends Controller
{
    public function index(Request $request, Int $id)
    {
        return new MediaResource(Media::find($id));
    }
}
