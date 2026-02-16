<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;
use Illuminate\Contracts\Hashing\Hasher;

class CreateUserAction
{
    use QueueableAction;

    public function __construct(
        private readonly User $userModel,
    ) {}

    /**
     * Create a new user.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): User
    {
        return $this->userModel->create($data);
    }
}
