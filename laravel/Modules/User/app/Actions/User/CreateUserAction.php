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
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): User
    {
        // users.name è NOT NULL senza default: i form di registrazione raccolgono solo nome e cognome,
        // quindi senza questo fallback ogni registrazione falliva con "Field 'name' doesn't have a default value".
        if (! isset($data['name']) || ! is_string($data['name']) || trim($data['name']) === '') {
            $first = is_string($data['first_name'] ?? null) ? $data['first_name'] : '';
            $last = is_string($data['last_name'] ?? null) ? $data['last_name'] : '';
            $fullName = trim($first.' '.$last);
            $email = is_string($data['email'] ?? null) ? $data['email'] : '';
            $localPart = strstr($email, '@', true);
            $data['name'] = $fullName !== '' ? $fullName : ($localPart !== false && $localPart !== '' ? $localPart : $email);
        }

        /** @var User $user */
        $user = app(User::class)->create($data);

        return $user;
    }
}
