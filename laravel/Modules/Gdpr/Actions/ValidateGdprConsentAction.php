<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Illuminate\Support\Facades\Log;
use Modules\Gdpr\Models\Consent;
use Modules\Gdpr\Models\Treatment;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per la validazione dei consensi GDPR durante la registrazione.
 * 
 * Estende QueueableAction per separazione responsabilità.
 */
class ValidateGdprConsentAction extends QueueableAction
{
    /**
     * Validate GDPR consent requirements.
     *
     * @param array<string, mixed> $data
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute(array $data): array
    {
        $validator = validator($data, [
            'privacy_policy_accepted' => 'required|accepted',
            'terms_accepted' => 'required|accepted',
            'data_processing_accepted' => 'required|accepted',
        ], [
            'privacy_policy_accepted.required' => __('gdpr::validation.privacy_policy_required'),
            'privacy_policy_accepted.accepted' => __('gdpr::validation.privacy_policy_accepted'),
            'terms_accepted.required' => __('gdpr::validation.terms_required'),
            'terms_accepted.accepted' => __('gdpr::validation.terms_accepted'),
            'data_processing_accepted.required' => __('gdpr::validation.data_processing_required'),
            'data_processing_accepted.accepted' => __('gdpr::validation.data_processing_accepted'),
        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator->errors()->toArray());
        }

        return $data;
    }

    /**
     * Get tags for the action.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['gdpr', 'validation', 'consent'];
    }

    /**
     * Get the display name for the action.
     *
     * @return string
     */
    public function displayName(): string
    {
        return 'Validate GDPR Consent Action';
    }

    /**
     * Get the description for the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Validates GDPR consent requirements during user registration.';
    }
}