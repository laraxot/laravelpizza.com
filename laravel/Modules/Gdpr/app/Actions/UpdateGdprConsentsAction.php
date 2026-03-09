<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions;

use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Update GDPR consents for an existing user (e.g. from profile settings).
 *
 * Delegates to SaveGdprConsentsAction — adds a new Consent record for each
 * preference so the audit trail is preserved.
 */
class UpdateGdprConsentsAction
{
    use QueueableAction;

    /**
     * @param array<string, bool> $consents
     */
    public function execute(User $user, array $consents, ?string $ipAddress = null, ?string $userAgent = null): void
    {
        app(SaveGdprConsentsAction::class)->execute($user, $consents, $ipAddress, $userAgent);
    }
}
