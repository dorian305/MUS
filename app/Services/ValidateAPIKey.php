<?php

namespace App\Services;

use App\Models\ApiKeys;
use Illuminate\Support\Facades\Hash;

class ValidateAPIKey
{
    public static function validate(String $apiKey, String $endpoint): Bool
    {
        $hashedKeys = ApiKeys::where('endpoint', $endpoint)
                                ->pluck('key')
                                ->toArray();
        
        foreach ($hashedKeys as $hashedKey){
            if (Hash::check($apiKey, $hashedKey)){
                return true;
            }
        }
        
        return false;
    }
}