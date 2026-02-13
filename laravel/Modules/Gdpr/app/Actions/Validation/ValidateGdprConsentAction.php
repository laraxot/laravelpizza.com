<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions\Validation;

use Illuminate\Validation\ValidationException;
use Spatie\QueueableAction\QueueableAction;

class ValidateGdprConsentAction
{
    use QueueableAction;

    /**
     * @throws ValidationException
     */
    public function execute(bool $privacyAccepted, bool $termsAccepted): void
    {
        $validator = validator(
            [
                'privacy_accepted' => $privacyAccepted,
                'terms_accepted' => $termsAccepted,
            ],
            [
                'privacy_accepted' => 'accepted',
                'terms_accepted' => 'accepted',
            ],
            [
                'privacy_accepted.accepted' => \__('gdpr::register.consents.privacy_policy_required'),
                'terms_accepted.accepted' => \__('gdpr::register.consents.terms_required'),
            ]
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
