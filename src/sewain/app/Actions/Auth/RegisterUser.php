<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterUser
{
    /**
     * @param array<string, mixed> $validated
     */
    public function execute(array $validated): User
    {
        $firstName = trim((string) ($validated['first_name'] ?? ''));
        $lastName = trim((string) ($validated['last_name'] ?? ''));

        $name = trim($firstName.' '.$lastName);

        return User::create([
            'name' => $name,
            'email' => (string) $validated['email'],
            'password' => Hash::make((string) $validated['password']),
            'role' => 'user',
            'status' => 'verify',
        ]);
    }
}
