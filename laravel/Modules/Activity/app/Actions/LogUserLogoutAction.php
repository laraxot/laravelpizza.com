<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

<<<<<<< .merge_file_LleDFJ
=======
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
>>>>>>> .merge_file_u7uvHK
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
<<<<<<< .merge_file_LleDFJ
        public User $user
    ) {}

    public function execute(): Activity
    {
        $action = new LogActivityAction(
            type: 'logout',
            user: $this->user,
            subject: $this->user,
=======
        public ?UserContract $user = null
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
>>>>>>> .merge_file_u7uvHK
            description: 'User logged out'
        );

        return $action->execute();
    }
}
