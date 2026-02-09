<?php

declare(strict_types=1);

namespace Modules\Gdpr\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Events\UserRegistered;

/**
 * Listener per salvare i consensi GDPR quando un utente si registra.
 * 
 * Questo listener implementa il pattern Event/Listener per decoupling
 * tra il modulo User (core) e il modulo Gdpr (opzionale).
 * 
 * Il modulo User non dipende più direttamente dal modulo Gdpr.
 * Quando un utente viene registrato, l'evento UserRegistered viene dispatchato
 * e questo listener (presente solo se il modulo Gdpr è attivo) salva i consensi.
 * 
 * @see \Modules\User\Events\UserRegistered
 * @see \Modules\User\Filament\Widgets\Auth\RegisterWidget
 */
class SaveGdprConsents
{
    /**
     * Handle the UserRegistered event.
     *
     * @param UserRegistered $event
     * @return void
     */
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;
        $formData = $event->formData;
        
        // Get or create treatments
        $treatments = Treatment::whereIn('name', [
            'privacy_policy',
            'terms_conditions',
            'data_processing',
            'marketing_consent',
            'profiling_consent',
            'analytics_consent',
            'third_party_consent',
        ])->get()->keyBy('name');

        // Map form field names to treatment names
        $consentMapping = [
            'privacy_policy_accepted' => 'privacy_policy',
            'terms_accepted' => 'terms_conditions',
            'data_processing_accepted' => 'data_processing',
            'marketing_consent' => 'marketing_consent',
            'profiling_consent' => 'profiling_consent',
            'analytics_consent' => 'analytics_consent',
            'third_party_consent' => 'third_party_consent',
        ];

        // Create consent records
        foreach ($consentMapping as $formField => $treatmentName) {
            if (!isset($formData[$formField])) {
                continue;
            }

            $isAccepted = (bool) $formData[$formField];
            $treatment = $treatments->get($treatmentName);

            if ($treatment) {
                Consent::create([
                    'user_id' => $user->id,
                    'user_type' => get_class($user),
                    'treatment_id' => $treatment->id,
                    'type' => $treatmentName,
                    'accepted_at' => $isAccepted ? now() : null,
                    'subject_id' => $user->id,
                    'ip_address' => $event->ipAddress,
                    'user_agent' => $event->userAgent,
                    'created_by' => 'system',
                    'updated_by' => 'system',
                ]);
            }
        }

        Log::info('GDPR consents saved for user registration', [
            'user_id' => $user->id,
            'ip' => $event->ipAddress,
            'consents' => array_keys($consentMapping),
        ]);
    }
}
