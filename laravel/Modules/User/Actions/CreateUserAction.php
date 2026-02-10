<?php

declare(strict_types=1);

namespace Modules\User\Actions;

use Illuminate\Support\Facades\Hash;
use Modules\User\Models\User;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per la creazione di un nuovo utente.
 * 
 * Segue il pattern Spatie QueueableAction per separazione responsabilità
 * e adherence ai principi Laraxot (DRY + KISS + SOLID + ROBUST).
 */
class CreateUserAction extends QueueableAction
{
    /**
     * Execute the action to create a new user.
     *
     * @param array<string, mixed> $data
     * @return User
     */
    public function execute(array $data): User
    {
        // Preparazione dati sicuri
        $userData = [
            'first_name' => app(SafeStringCastAction::class)->execute($data['first_name']),
            'last_name' => app(SafeStringCastAction::class)->execute($data['last_name']),
            'email' => app(SafeStringCastAction::class)->execute($data['email']),
            'password' => Hash::make(
                app(SafeStringCastAction::class)->execute($data['password'])
            ),
            'type' => 'customer_user',
            'state' => 'active',
            'email_verified_at' => now(),
        ];

        // Creazione utente
        $user = User::create($userData);

        // Activity logging (se necessario)
        activity('user')
            ->causedBy($user)
            ->performedOn($user)
            ->withProperties([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'source' => 'registration_form',
            ])
            ->log('User created via CreateUserAction');

        return $user;
    }

    /**
     * Get tags for the action.
     *
     * @return array<string>
     */
    public function tags(): array
    {
        return ['user', 'registration', 'creation'];
    }

    /**
     * Get the display name for the action.
     *
     * @return string
     */
    public function displayName(): string
    {
        return 'Create User Action';
    }

    /**
     * Get the description for the action.
     *
     * @return string
     */
    public function description(): string
    {
        return 'Creates a new user with safe data processing and logging.';
    }
}