<?php

namespace App\Services;

use App\Models\ApiKeys;
use Illuminate\Support\Facades\Hash;

class ValidateAPIKey
{
    public static function validate(String $apiKey, String $endpoint, String $ip): Bool
    {
        $key_db = ApiKeys::where('endpoint', $endpoint)
                            ->where("ip", $ip)
                            ->pluck('key')
                            ->first();

        return Hash::check($apiKey, $key_db);
    }
}