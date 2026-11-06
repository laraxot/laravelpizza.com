<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions\Consent;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Salva i consensi GDPR inviati nel form di registrazione (evento UserRegistered).
 *
 * Logica spostata dal listener `SaveGdprConsents`: il listener resta un adattatore
 * sottile, il comportamento (7 trattamenti, created_by `system`) e' invariato.
 */
class SaveRegistrationConsentsAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $formData  Dati grezzi del form di registrazione
     */
    public function execute(User $user, array $formData, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        $treatments = Treatment::query()->whereIn('name', [
            'privacy_policy',
            'terms_conditions',
            'data_processing',
            'marketing_consent',
            'profiling_consent',
            'analytics_consent',
            'third_party_consent',
        ])->get()->keyBy('name');

        // Nome campo del form => nome del trattamento
        $consentMapping = [
            'privacy_policy_accepted' => 'privacy_policy',
            'terms_accepted' => 'terms_conditions',
            'data_processing_accepted' => 'data_processing',
            'marketing_consent' => 'marketing_consent',
            'profiling_consent' => 'profiling_consent',
            'analytics_consent' => 'analytics_consent',
            'third_party_consent' => 'third_party_consent',
        ];

        foreach ($consentMapping as $formField => $treatmentName) {
            if (! isset($formData[$formField])) {
                continue;
            }

            $isAccepted = (bool) $formData[$formField];
            $treatment = $treatments->get($treatmentName);

            if ($treatment) {
                Consent::query()->create([
                    'user_id' => $user->id,
                    'user_type' => $user::class,
                    'treatment_id' => $treatment->id,
                    'type' => $treatmentName,
                    'accepted_at' => $isAccepted ? now() : null,
                    'subject_id' => $user->id,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                    'created_by' => 'system',
                    'updated_by' => 'system',
                ]);
            }
        }

        Log::debug('GDPR consents saved for user registration', [
            'user_id' => $user->id,
            'ip' => $ipAddress,
            'consents' => array_keys($consentMapping),
        ]);
    }
}
