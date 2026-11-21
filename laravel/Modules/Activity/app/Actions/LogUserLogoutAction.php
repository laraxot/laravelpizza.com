<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Modules\Activity\Models\Activity;
use Modules\Xot\Contracts\UserContract;
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
<<<<<<< .merge_file_FiLMuj
        public ?UserContract $user = null
=======
        public ?UserContract $user = null,
>>>>>>> .merge_file_7EyseF
    ) {}

    public function execute(?UserContract $user = null): Activity
    {
        $user = $user ?? $this->user;
        if (! $user instanceof Model) {
            throw new InvalidArgumentException('User must implement UserContract and extend Model');
        }

        $action = new LogActivityAction(
            type: 'logout',
            user: $user,
            subject: $user,
<<<<<<< .merge_file_FiLMuj
            description: 'User logged out'
=======
            description: 'User logged out',
>>>>>>> .merge_file_7EyseF
        );

        return $action->execute();
    }
}
