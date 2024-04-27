<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username'  =>  ["required", "string", "min:4", "max:10", "unique:users,username"],
            'email'     =>  ["required", "string", "email", "unique:users,email"],
            'passwrd'  =>  ["required", "confirmed", "string", Password::min(8)->letters()->numbers()->symbols()],
            'passwrd_confirmation'  =>  ["required", "string", Password::min(8)->letters()->numbers()->symbols()],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(
            data: ["errors" => $validator->errors()],
            status: 422,
        );

        throw new HttpResponseException($response);
    }
}
