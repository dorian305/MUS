<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use App\Models\ApiKeys;

class ValidApiKey implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $hashedKeys = ApiKeys::where('endpoint', $endpoint)
        //                         ->pluck('key')
        //                         ->toArray();
        
        // foreach ($hashedKeys as $hashedKey){
        //     if (Hash::check($apiKey, $hashedKey)){
        //         return true;
        //     }
        // }
        
        // return false;
    }
}
