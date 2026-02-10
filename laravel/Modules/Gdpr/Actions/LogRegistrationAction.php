<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per il logging della registrazione.
 * 
 * Estende QueueableAction per separazione responsabilità.
 */
class LogRegistrationAction extends QueueableAction
{
    /**
     * Log registration attempt.
     *
     * @param User $user
     * @param array<string, mixed> $formData
     * @return void
     */
    public function execute(User $user, array $formData): void
    {
        Log::info('User registered', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'registration_data_keys' => array_keys($formData),
        ]);
    }

    /**
     * Get tags for the action.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['user', 'registration', 'logging'];
    }

    /**
     * Get the display name for the action.
     *
     * @return string
     */
    public function displayName(): string
    {
        return 'Log Registration Action';
    }

    /**
     * Get the description for the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Logs user registration attempts with security details.';
    }
}