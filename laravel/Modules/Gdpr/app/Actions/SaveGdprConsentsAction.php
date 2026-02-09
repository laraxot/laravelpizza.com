<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

class SaveGdprConsentsAction
{
    use QueueableAction;

    /**
     * Save all GDPR consents for a user.
     *
     * @param User                 $user
     * @param array<string, bool> $consents Associative array of consent properties (privacy_accepted, terms_accepted, etc.)
     * @param string|null          $ipAddress
     * @param string|null          $userAgent
     */
    public function execute(User $user, array $consents, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        $ipAddress ??= request()->ip();
        $userAgent ??= request()->userAgent();

        $treatments = Treatment::whereIn('name', [
            'privacy_policy',
            'terms_conditions',
            'marketing_consent',
        ])->get()->keyBy('name');

        $consentMapping = [
            'privacy_accepted' => 'privacy_policy',
            'terms_accepted' => 'terms_conditions',
            'marketing_consent' => 'marketing_consent',
        ];

        foreach ($consentMapping as $property => $treatmentName) {
            $isAccepted = $consents[$property] ?? false;
            $treatment = $treatments->get($treatmentName);

            if ($treatment) {
                Consent::create([
                    'user_id' => $user->id,
                    'user_type' => get_class($user),
                    'treatment_id' => $treatment->id,
                    'type' => $treatmentName,
                    'accepted_at' => $isAccepted ? now() : null,
                    'subject_id' => $user->id,
                    'created_by' => 'gdpr_register_widget',
                    'updated_by' => 'gdpr_register_widget',
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                ]);
            }
        }

        Log::info('GDPR consents saved via action', [
            'user_id' => $user->id,
            'ip' => $ipAddress,
            'consents' => $consents,
        ]);
    }
}
