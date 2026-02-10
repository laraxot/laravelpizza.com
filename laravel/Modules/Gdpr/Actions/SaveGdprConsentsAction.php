<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per il salvataggio dei consensi GDPR.
 * 
 * Estende QueueableAction per separazione responsabilità.
 */
class SaveGdprConsentsAction extends QueueableAction
{
    /**
     * Save GDPR consents for a user.
     *
     * @param User $user
     * @param array<string> $consentTypes
     * @return void
     */
    public function execute(User $user, array $consentTypes): void
    {
        $treatments = Treatment::whereIn('name', $consentTypes)->get();
        
        foreach ($consentTypes as $consentType) {
            $treatment = $treatments->firstWhere('name', $consentType);
            
            if (!$treatment) {
                Log::warning("Treatment '{$consentType}' not found for user {$user->id}");
                continue;
            }
            
            // Crea o aggiorna il consenso
            Consent::updateOrCreate([
                'user_id' => $user->id,
                'user_type' => get_class($user),
                'treatment_id' => $treatment->id,
                'type' => $consentType,
                'accepted_at' => now(),
            ], [
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }
        
        Log::info('GDPR consents saved', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'consents' => $consentTypes,
            'ip' => request()->ip(),
        ]);
    }

    /**
     * Get tags for the action.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['gdpr', 'consent', 'save'];
    }

    /**
     * Get the display name for the action.
     *
     * @return string
     */
    public function displayName(): string
    {
        return 'Save GDPR Consents Action';
    }

    /**
     * Get the description for the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Saves GDPR consents for a user with audit trail.';
    }
}