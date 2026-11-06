<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\NewPasswordSet;
use Modules\Xot\Datas\XotData;
use Webmozart\Assert\Assert;

class ChangePasswordCommand extends Command
{
    protected $signature = 'user:change-password {--email= : Email dell\'utente}';

    protected $description = 'Change user password';

    public function handle(): void
    {
        $emailInput = $this->option('email') ?? $this->ask('Enter the user email:');
        Assert::string($emailInput);

        $email = strtolower(trim($emailInput));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email non valida: '.$emailInput);

            return;
        }

        $user = XotData::make()->findUserByEmail($email);

        if ($user === null) {
            $this->error("Utente non trovato per email: {$email}");

            return;
        }

        Assert::string($password = $this->secret('Enter the new password:'));
        $confirmPassword = $this->secret('Confirm the new password:');

        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');

            return;
        }

        $pwdData = PasswordData::make();
        $passwordExpiryDateTime = now()->addDays($pwdData->expires_in);

        $user = tap($user)->update([
            'password_expires_at' => $passwordExpiryDateTime,
            'is_otp' => false,
            'password' => Hash::make($password),
        ]);

        event(new NewPasswordSet($user));

        $this->info('Password changed successfully!');
    }
}
