<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Modules\User\Events\NewPasswordSet;
use Modules\Xot\Datas\XotData;

class ChangePasswordCommand extends Command
{
    protected $signature = 'user:change-password';
    protected $description = 'Change user password';

    public function handle(): void
    {
        $email = (string) $this->ask('Enter the user email:');
        try {
            $user = XotData::make()->getUserByEmail($email);
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return;
        }

        $password = (string) $this->secret('Enter the new password:');
        $confirmPassword = (string) $this->secret('Confirm the new password:');

        if ($password !== $confirmPassword) {
            $this->error('Passwords do not match!');

            return;
        }

        $user->update([
            'password' => Hash::make($password),
        ]);

        event(new NewPasswordSet($user));
        $this->info('Password changed successfully!');
    }
}
