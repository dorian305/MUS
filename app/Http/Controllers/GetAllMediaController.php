<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Media;
use App\Http\Resources\MediaCollection;

class GetAllMediaController extends Controller
{
    public function index(Request $request)
    {
        return new MediaCollection(Media::all());
    }
}
