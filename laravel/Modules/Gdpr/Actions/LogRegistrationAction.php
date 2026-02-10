<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Factory as ValidationFactory;
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
    private ValidationFactory $validator;
    
    public function __construct(ValidationFactory $validator = null)
    {
        $this->validator = $validator ?? app(ValidationFactory::class);
    }

    /**
     * Log registration attempt.
     *
     * @param User $user
     * @param array<string> $formData
     * @return void
     */
    public function execute(User $user, array $formData): void
    {
        Log::info('User registration attempt', [
            'user_id' => $user->id,
            'email' => $user->email,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'form_data_keys' => array_keys($formData),
            'has_gdpr_consent' => !empty(array_filter($formData, function ($key) {
                return str_starts_with($key, 'gdpr_');
            })),
            'registration_source' => 'gdpr_register_widget',
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
        return 'Logs user registration attempts with security details and GDPR consent tracking.';
    }
}