<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class RegisterUserAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): User
    {
        $firstName = $data['first_name'] ?? '';
        $lastName = $data['last_name'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        Assert::string($firstName);
        Assert::string($lastName);
        Assert::string($email);
        Assert::string($password);

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        Auth::login($user);

        return $user;
    }
}
