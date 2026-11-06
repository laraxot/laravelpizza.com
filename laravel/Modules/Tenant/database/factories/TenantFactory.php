<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\Tenant;

/**
 * @extends Factory<Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Tenant>
     */
    protected $model = Tenant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company();

        return [
            'id' => $this->faker->uuid(),
            'name' => $name,
            'slug' => $this->faker->unique()->slug(),
            'domain' => $this->faker->domainName(),
            'database' => 'tenant_'.$this->faker->unique()->slug(),
            'is_active' => $this->faker->boolean(80),
            // `settings` non è nella factory di default: lo schema sqlite condiviso
            // può non avere la colonna (drift migration). Usare withSettings().
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

    /**
     * @param  array<string, mixed>  $settings
     */
    public function withSettings(array $settings = []): static
    {
        return $this->state(fn (array $_attributes) => [
            'settings' => $settings !== [] ? $settings : [
                'timezone' => 'Europe/Rome',
                'locale' => 'it',
                'currency' => 'EUR',
            ],
        ]);
    }

    /**
     * Indicate that the tenant is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $_attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the tenant is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $_attributes) => [
            'is_active' => false,
        ]);
    }
}
