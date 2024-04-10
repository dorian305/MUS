<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidateRequest
{
    public static function validateData(Array $receivedData, Array $expectedData) : Array
    {
        $validationDetails = [
            'success' => true,
        ];
        
        $validator = Validator::make($receivedData, $expectedData);

        if ($validator->fails()){
            $validationDetails['success'] = false;
            $validationDetails['errors']  = $validator->errors();
        }

        return $validationDetails;
    }
}