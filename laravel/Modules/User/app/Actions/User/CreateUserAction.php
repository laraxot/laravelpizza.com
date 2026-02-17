<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

class CreateUserAction
{
    use QueueableAction;

    /**
     * Create a new user.
     *
     * @param array<string, mixed> $data
     */
    public function execute(array $data): User
    {
        // Use app() to resolve the User model instance
        return app(User::class)->create($data);
    }
}
