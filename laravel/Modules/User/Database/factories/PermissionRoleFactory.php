<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Permission;
use Modules\User\Models\PermissionRole;
use Modules\User\Models\Role;

/**
 * PermissionRole Factory.
 *
 * Factory for creating PermissionRole model instances for testing and seeding.
 *
 * @extends Factory<PermissionRole>
 */
class PermissionRoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<PermissionRole>
     */
    protected $model = PermissionRole::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permission_id' => fn () => Permission::create([
                'name' => fake()->unique()->slug(),
                'guard_name' => 'web',
            ])->id,
            'role_id' => fn () => Role::create([
                'name' => fake()->unique()->slug(),
                'guard_name' => 'web',
            ])->id,
        ];
    }

    /**
     * Create permission-role relationship for a specific permission.
     */
    public function forPermission(Permission $permission): static
    {
        return $this->state(fn (array $_attributes): array => [
            'permission_id' => $permission->id,
        ]);
    }

    /**
     * Create permission-role relationship for a specific role.
     */
    public function forRole(Role $role): static
    {
        return $this->state(fn (array $_attributes): array => [
            'role_id' => $role->id,
        ]);
    }
}
