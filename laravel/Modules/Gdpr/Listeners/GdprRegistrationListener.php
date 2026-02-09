<?php

declare(strict_types=1);

namespace Modules\Gdpr\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Enums\ConsentType;
use Modules\User\Events\UserRegistered;

/**
 * Listener GdprRegistrationListener.
 *
 * Handles GDPR consent storage when a user registers.
 * Automatically saves all consent types given during registration.
 */
class GdprRegistrationListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Mapping from form field names to ConsentType enum values.
     *
     * @var array<string, string>
     */
    private const CONSENT_MAPPING = [
        'privacy_policy_accepted' => ConsentType::PRIVACY_POLICY->value,
        'terms_accepted' => ConsentType::TERMS_AND_CONDITIONS->value,
        'data_processing_accepted' => ConsentType::PERSONALIZATION->value,
        'marketing_consent' => ConsentType::MARKETING_EMAIL->value,
        'profiling_consent' => ConsentType::PROFILING->value,
        'analytics_consent' => ConsentType::ANALYTICS->value,
        'third_party_consent' => ConsentType::THIRD_PARTY_SHARING->value,
    ];

    /**
     * Handle the UserRegistered event.
     *
     * Saves all GDPR consents given during registration.
     *
     * @param UserRegistered $event
     */
    public function handle(UserRegistered $event): void
    {
        try {
            $gdprConsents = $event->getGdprConsents();
            $user = $event->user;

            foreach ($gdprConsents as $field => $accepted) {
                if ($accepted && isset(self::CONSENT_MAPPING[$field])) {
                    $this->saveConsent($user, self::CONSENT_MAPPING[$field], $event);
                }
            }

            Log::info('GDPR consents saved for user registration', [
                'user_id' => $user->id,
                'consents_given' => array_filter($gdprConsents, fn ($v) => $v),
                'ip' => $event->ipAddress,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save GDPR consents during registration', [
                'user_id' => $event->user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Re-throw to trigger retry mechanism
            throw $e;
        }
    }

    /**
     * Save a single consent for the user.
     *
     * @param \Modules\User\Models\User $user
     * @param string $consentType
     * @param UserRegistered $event
     */
    private function saveConsent($user, string $consentType, UserRegistered $event): void
    {
        $metadata = [
            'registration_source' => 'register_widget',
            'ip_address' => $event->ipAddress,
            'user_agent' => $event->userAgent,
            'registered_at' => now()->toIso8601String(),
        ];

        $user->giveConsent($consentType, $metadata);
    }
}