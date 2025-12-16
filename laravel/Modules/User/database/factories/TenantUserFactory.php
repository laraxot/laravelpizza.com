<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Models\Tenant;
use Modules\User\Models\TenantUser;
use Modules\User\Models\User;

/**
 * TenantUser Factory.
 *
 * Factory for creating TenantUser model instances for testing and seeding.
 *
 * @extends Factory<TenantUser>
 */
class TenantUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TenantUser>
     */
    protected $model = TenantUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Create tenant-user relationship for a specific tenant.
     */
    public function forTenant(Tenant $tenant): static
    {
        return $this->state(fn (array $_attributes): array => [
            'tenant_id' => $tenant->id,
        ]);
    }

    /**
     * Create tenant-user relationship for a specific user.
     */
    public function forUser(User $user): static
    {
        return $this->state(fn (array $_attributes): array => [
            'user_id' => $user->id,
        ]);
    }
}
