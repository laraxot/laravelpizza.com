<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log User Logout Action
 *
 * Logs when a user logs out using Queueable Actions
 */
class LogUserLogoutAction
{
    use QueueableAction;

    public function __construct(
        public User $user
    ) {
    }

    public function execute(): Activity
    {
        $action = new LogActivityAction(
            type: 'logout',
            user: $this->user,
            subject: $this->user,
            description: 'User logged out'
        );

        return $action->execute();
    }
}
