<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions\Validation;

use Illuminate\Support\Facades\Hash;
use Modules\User\Datas\PasswordData;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

class ValidateUserDataAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $formData
     * @return array<string, mixed>
     */
    public function execute(array $formData): array
    {
        return [
            'first_name' => app(SafeStringCastAction::class)->execute($formData['first_name']),
            'last_name' => app(SafeStringCastAction::class)->execute($formData['last_name']),
            'email' => app(SafeStringCastAction::class)->execute($formData['email']),
            'password' => Hash::make(
                app(SafeStringCastAction::class)->execute($formData['password']),
            ),
            'type' => 'customer_user',
            'state' => 'active',
            'email_verified_at' => now(),
        ];
    }
}