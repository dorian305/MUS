<?php

namespace App\Http\Controllers;

use App\Models\ApiKeys;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class KeyController extends Controller
{
    public function generate(Request $request)
    {
        // Generates a 100 character API key
        $key = bin2hex((random_bytes(50)));
        $hashedKey = Hash::make($key);

        // If IP making the request is present in the database, update existing api key.
        $existing_key = ApiKeys::where("ip", $request->ip())->first();
        if ($existing_key){
            $existing_key->update(['key' => $hashedKey]);

            return new JsonResponse(
                data: ['apiKey' => $key],
                status: 200,
            );
        }

        // Store the generated key
        $newKey = new ApiKeys();
        $newKey->key = $hashedKey;
        $newKey->endpoint = "api/upload/media";
        $newKey->ip = $request->ip();
        $newKey->save();

        return new JsonResponse(
            data: ['apiKey' => $key],
            status: 200,
        );
    }
}
