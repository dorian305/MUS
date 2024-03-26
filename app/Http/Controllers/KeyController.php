<?php

namespace App\Http\Controllers;

use App\Models\ApiKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KeyController extends Controller
{
    public function generate(Request $request)
    {
        // Generates a 100 character API key
        $key = bin2hex((random_bytes(50)));
        $hashedKey = Hash::make($key);

        // Store the generated key
        $newKey = new ApiKeys();
        $newKey->key = $hashedKey;
        $newKey->endpoint = "/upload/media";
        $newKey->save();

        return response()->json([
            'key' => $key,
        ]);
    }
}
