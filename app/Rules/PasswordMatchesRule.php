<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Hash;

class PasswordMatchesRule implements ValidationRule
{
    private $data;

    public function __construct(Array $data)
    {
        $this->data = $data;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where("username", $this->data['identifier'] ?? "")
                    ->orWhere("email", $this->data['identifier'] ?? "")
                    ->first();

        if (!$user || !Hash::check($value, $user->password)) {
            $fail("Invalid credentials provided.");
        }
    }
}
