<?php

declare(strict_types=1);

namespace Modules\User\Actions\User;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Hashing\Hasher;
use Modules\User\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * @see docs/contracts/delete-user-action.md
 *
 * @contract docs/contracts/delete-user-action.md
 */
class DeleteUserAction
{
    use QueueableAction;

    public function __construct(
        private readonly Hasher $hasher,
        private readonly Guard $authGuard,
    ) {}

    /**
     * Elimina l'utente dopo aver verificato la password.
     *
     * @return array{success: bool, message: string}
     */
    public function execute(UserContract $user, string $confirmPassword): array
    {
        $hashedPassword = $user->getAttribute('password');
        if (! is_string($hashedPassword) || ! $this->hasher->check($confirmPassword, $hashedPassword)) {
            return [
                'success' => false,
                'message' => 'The password you entered is incorrect',
            ];
        }

        try {
            $this->authGuard->logout();
            $user->delete();

            return [
                'success' => true,
                'message' => 'Account deleted successfully',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'An error occurred while deleting the account',
            ];
        }
    }
}
