<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Media;

class GetMedia extends Controller
{
    public function index(Request $request, Int $page)
    {
        return Media::paginate($page);
    }
}
