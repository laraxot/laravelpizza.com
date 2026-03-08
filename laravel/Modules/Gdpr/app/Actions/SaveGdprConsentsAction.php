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
     * @param array<string, bool> $consents Associative array of [treatment_name => bool]
     */
    public function execute(User $user, array $consents, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        $ipAddress ??= request()->ip();
        $userAgent ??= request()->userAgent();

        $allActiveTreatments = Treatment::where('active', 1)->get()->keyBy('name');

        foreach ($consents as $treatmentName => $isAccepted) {
            $treatment = $allActiveTreatments->get($treatmentName);

            if ($treatment) {
                Consent::create([
                    'user_id' => $user->id,
                    'user_type' => get_class($user),
                    'treatment_id' => $treatment->id,
                    'type' => $treatmentName,
                    'accepted_at' => $isAccepted ? now() : null,
                    'subject_id' => $user->id,
                    'created_by' => 'gdpr_save_action',
                    'updated_by' => 'gdpr_save_action',
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                ]);
            }
        }

        Log::info('GDPR consents saved', [
            'user_id' => $user->id,
            'ip' => $ipAddress,
            'consents_count' => count($consents),
        ]);
    }
}
