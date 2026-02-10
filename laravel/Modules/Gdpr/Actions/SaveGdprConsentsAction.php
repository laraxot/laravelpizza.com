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
 * Action per il salvataggio dei consensi GDPR.
 * 
 * Estende QueueableAction per separazione responsabilità.
 * Usa il container Laravel per risolvere le dipendenze correttamente.
 */
class SaveGdprConsentsAction extends QueueableAction
{
    private ValidationFactory $validator;
    private \Psr\Log\LoggerInterface $logger;

    public function __construct(ValidationFactory $validator, \Psr\Log\LoggerInterface $logger)
    {
        $this->validator = $validator;
        $this->logger = $logger;
    }

    /**
     * Save GDPR consents for a user.
     *
     * @param User $user
     * @param array<string> $consentTypes
     * @return void
     */
    public function execute(User $user, array $consentTypes): void
    {
        foreach ($consentTypes as $consentType) {
            $treatment = Treatment::where('name', $consentType)->first();
            
            if (!$treatment) {
                $this->logger->warning("GDPR treatment '{$consentType}' not found for user {$user->id}");
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
        
        $this->logger->info('GDPR consents saved', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'consent_types' => $consentTypes,
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
        return 'Saves GDPR consents with proper audit trail and logging.';
    }
}