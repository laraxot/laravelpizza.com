<?php

declare(strict_types=1);

namespace Modules\Tenant\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Tenant\Models\Domain;

/**
 * @extends Factory<Domain>
 */
class DomainFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Domain>
     */
    protected $model = Domain::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'domain' => ['example.com', 'test.com', 'demo.org', 'sample.net', 'example.it'][array_rand(['example.com', 'test.com', 'demo.org', 'sample.net', 'example.it'])],
            'is_primary' => random_int(1, 100) <= 20, // 20% chance
            'is_ssl_enabled' => random_int(1, 100) <= 80, // 80% chance
            'is_active' => random_int(1, 100) <= 90, // 90% chance
            'created_at' => \Carbon\Carbon::now()->subDays(random_int(1, 365)),
            'updated_at' => \Carbon\Carbon::now()->subDays(random_int(0, 30)),
        ];
    }

    /**
     * Indicate that the domain is primary.
     */
    public function primary(): static
    {
        return $this->state(fn (array $_attributes) => [
            'is_primary' => true,
        ]);
    }

    /**
     * Indicate that the domain is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $_attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that SSL is enabled.
     */
    public function sslEnabled(): static
    {
        return $this->state(fn (array $_attributes) => [
            'is_ssl_enabled' => true,
        ]);
    }
}
