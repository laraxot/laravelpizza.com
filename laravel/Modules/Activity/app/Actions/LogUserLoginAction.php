<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\Activity;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Log User Login Action
 *
 * Logs when a user logs in using Queueable Actions
 */
class LogUserLoginAction
{
    use QueueableAction;

    public function __construct(
        public User $user
    ) {
    }

    public function execute(): Activity
    {
        $action = new LogActivityAction(
            type: 'login',
            user: $this->user,
            subject: $this->user,
            description: 'User logged in'
        );

        return $action->execute();
    }
}