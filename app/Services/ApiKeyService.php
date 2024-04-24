<?php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Support\Facades\Hash;

class ApiKeyService
{
    public static function get(String $ip)
    {
        // Generates a 100 character string.
        $key = bin2hex((random_bytes(50)));

        $existing_api_key = ApiKey::where("ip", $ip)
                            ->get()
                            ->first();
        if ($existing_api_key){
            $existing_api_key->update(["key" => Hash::make($key)]);

            return $key;
        }

        $new_api_key = new ApiKey();
        $new_api_key->ip = $ip;
        $new_api_key->key = Hash::make($key);
        $new_api_key->save();

        return $key;
    }
}