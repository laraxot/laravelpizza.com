<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions\Validation;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

class ValidateUserDataAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $formData
     *
     * @return array<string, mixed>
     */
    public function execute(array $formData): array
    {
        $email = app(SafeStringCastAction::class)->execute($formData['email']);

        // Prevent duplicate email before hitting DB unique constraint.
        // User model already uses 'user' connection via $connection property
        if (User::where('email', $email)->exists()) {
            throw ValidationException::withMessages([
                'email' => [__('validation.unique', ['attribute' => 'email'])],
            ]);
        }

        return [
            'first_name' => app(SafeStringCastAction::class)->execute($formData['first_name']),
            'last_name' => app(SafeStringCastAction::class)->execute($formData['last_name']),
            'email' => $email,
            'password' => Hash::make(
                app(SafeStringCastAction::class)->execute($formData['password']),
            ),
            'type' => 'customer_user',
            'lang' => app()->getLocale(),
            'email_verified_at' => now(),
        ];
    }
}
