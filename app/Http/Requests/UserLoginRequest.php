<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use App\Rules\IdentifierExistsRule;
use App\Rules\PasswordMatchesRule;

class UserLoginRequest extends FormRequest
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
            'identifier' => ["required", "string", new IdentifierExistsRule],
            'password' => ["required", "string", new PasswordMatchesRule($this->all())],
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
