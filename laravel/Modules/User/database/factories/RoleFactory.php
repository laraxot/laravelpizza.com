<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Role;

/**
 * Factory per il modello Role del modulo User.
 *
 * @extends Factory<Role>
 */
class RoleFactory extends Factory
{
    /**
     * Il nome del modello corrispondente alla factory.
     *
     * @var class-string<Role>
     */
    protected $model = Role::class;

    /**
     * Definisce lo stato di default del modello.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            'admin' => 'Administrator',
            'manager' => 'Manager',
            'editor' => 'Editor',
            'user' => 'User',
            'moderator' => 'Moderator',
            'viewer' => 'Viewer',
            'contributor' => 'Contributor',
            'analyst' => 'Analyst',
            'support' => 'Support Agent',
            'developer' => 'Developer',
        ];

        $role = $this->faker->randomElement($roles);
        $name = array_search($role, $roles, strict: true);

        return [
            'name' => $name,
            'guard_name' => 'web',
        ];
    }

    /**
     * Crea un ruolo admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => 'admin',
        ]);
    }

    /**
     * Crea un ruolo manager.
     */
    public function manager(): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => 'manager',
        ]);
    }

    /**
     * Crea un ruolo user.
     */
    public function user(): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => 'user',
        ]);
    }

    /**
     * Crea un ruolo con un guard specifico.
     */
    public function withGuard(string $guard): static
    {
        return $this->state(fn (array $_attributes) => [
            'guard_name' => $guard,
        ]);
    }
}
