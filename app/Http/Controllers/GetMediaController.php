<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Media;
use App\Http\Resources\MediaResource;

class GetMediaController extends Controller
{
    public function index(Request $request, Int $id)
    {
        return new MediaResource(Media::find($id));
    }
}
