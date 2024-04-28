<?php

namespace App\Services;

use App\Models\ApiKey;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiKeyService
{
    public function get(User $user): String
    {
        // Generates a 100 character string.
        $key = bin2hex((random_bytes(50)));

        $existing_api_key = ApiKey::where("user_id", $user->id)
                            ->get()
                            ->first();
        if ($existing_api_key){
            $existing_api_key->update(["key" => Hash::make($key)]);

            return $key;
        }

        $new_api_key = new ApiKey();
        $new_api_key->user_id = $user->id;
        $new_api_key->key = Hash::make($key);
        $new_api_key->save();

        return $key;
    }

    public function validate(User $user, String $api_key): Bool
    {
        $api_key_db = ApiKey::where("user_id", $user->id)
                    ->pluck('key')
                    ->first();
        
        return Hash::check($api_key, $api_key_db);
    }
}