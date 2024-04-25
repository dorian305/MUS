<?php

namespace App\Http\Controllers\Media;

use Illuminate\Http\Request;

use App\Models\Media;
use App\Http\Resources\MediaCollection;

use App\Http\Controllers\Controller;

class GetAllMediaController extends Controller
{
    public function index(Request $request): MediaCollection
    {
        return new MediaCollection(Media::all());
    }
}
