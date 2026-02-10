<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions\Consent;

use Spatie\QueueableAction\QueueableAction;

class CollectGdprConsentsAction
{
    use QueueableAction;

    /**
     * @return array<string, bool>
     */
    public function execute(bool $privacyAccepted, bool $termsAccepted, bool $marketingConsent): array
    {
        return [
            'privacy_accepted' => $privacyAccepted,
            'terms_accepted' => $termsAccepted,
            'marketing_consent' => $marketingConsent,
        ];
    }
}
