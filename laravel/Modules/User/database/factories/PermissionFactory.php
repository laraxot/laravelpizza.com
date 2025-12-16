<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Permission;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

/**
 * Factory per il modello Permission del modulo User.
 *
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Permission>
     */
    protected $model = Permission::class;

    /**
     * Definisce lo stato di default del modello.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $actions = ['create', 'read', 'update', 'delete', 'manage', 'view', 'edit'];
        $resources = [
            'users',
            'posts',
            'comments',
            'pages',
            'settings',
            'reports',
            'analytics',
            'teams',
            'roles',
            'permissions',
        ];

        $action = SafeStringCastAction::cast($this->faker->randomElement($actions));
        $resource = SafeStringCastAction::cast($this->faker->randomElement($resources));

        return [
            'name' => $action.' '.$resource,
            'guard_name' => 'web',
        ];
    }

    /**
     * Crea un set di permessi CRUD per una risorsa.
     */
    public function forResource(string $resource): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => SafeStringCastAction::cast($this->faker->randomElement(['create', 'read', 'update', 'delete'])).
                    ' '.
                    $resource,
        ]);
    }

    /**
     * Crea un permesso di lettura.
     */
    public function read(): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => 'read '.
                    SafeStringCastAction::cast($this->faker->randomElement(['users', 'posts', 'comments', 'pages'])),
        ]);
    }

    /**
     * Crea un permesso di scrittura.
     */
    public function write(): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => SafeStringCastAction::cast($this->faker->randomElement(['create', 'update', 'delete'])).
                    ' '.
                    SafeStringCastAction::cast($this->faker->randomElement(['users', 'posts', 'comments', 'pages'])),
        ]);
    }

    /**
     * Crea un permesso admin.
     */
    public function admin(): static
    {
        return $this->state(fn (array $_attributes) => [
            'name' => 'manage '.
                    SafeStringCastAction::cast($this->faker->randomElement([
                        'users',
                        'system',
                        'settings',
                        'permissions',
                    ])),
        ]);
    }

    /**
     * Crea un permesso con un guard specifico.
     */
    public function withGuard(string $guard): static
    {
        return $this->state(fn (array $_attributes) => [
            'guard_name' => $guard,
        ]);
    }
}
