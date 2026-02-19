<?php

declare(strict_types=1);

namespace Modules\User\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

/**
 * Event fired when a new user is registered.
 * Listeners can hook into this to perform additional actions
 * (e.g., GDPR consent saving, welcome emails, etc.).
 */
class UserRegistered
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param User                 $user      The newly created user
     * @param array<string, mixed> $formData  Raw form data from registration
     * @param string|null          $ipAddress IP address of the registrant
     * @param string|null          $userAgent User agent of the registrant
     */
    public function __construct(
        public User $user,
        public array $formData,
        public ?string $ipAddress = null,
        public ?string $userAgent = null,
    ) {
    }
}
