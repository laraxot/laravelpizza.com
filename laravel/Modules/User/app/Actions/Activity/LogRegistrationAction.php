<?php

declare(strict_types=1);

namespace Modules\User\Actions\Activity;

use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

<<<<<<< HEAD
=======
/**
 * @see docs/contracts/log-registration-action.md
 * @contract docs/contracts/log-registration-action.md
 */
>>>>>>> laraxot/dev
class LogRegistrationAction
{
    use QueueableAction;

    /**
     * Log a successful user registration activity.
     *
     * @param  array<string, mixed>  $properties  Extra properties to log
     */
    public function execute(User $user, array $properties = []): void
    {
        activity()
            ->withProperties(array_merge([
                'type' => $user->type,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ], $properties))
            ->log('User registered via GDPR-compliant RegisterWidget');
    }
}
