<?php

declare(strict_types=1);

namespace Modules\Activity\Actions;

<<<<<<< .merge_file_NFTOah
=======
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
>>>>>>> .merge_file_kcjJsT
use Modules\Activity\Models\Activity;
use Modules\Xot\Contracts\UserContract;
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
<<<<<<< .merge_file_NFTOah
        public User $user
    ) {}

    public function execute(): Activity
    {
        $action = new LogActivityAction(
            type: 'login',
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
            type: 'login',
            user: $user,
            subject: $user,
>>>>>>> .merge_file_kcjJsT
            description: 'User logged in'
        );

        return $action->execute();
    }
}
