<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class LoginUserAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): bool
    {
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $remember = (bool) ($data['remember'] ?? false);

        Assert::string($email);
        Assert::string($password);

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            session()->regenerate();
            return true;
        }

        return false;
    }
}
