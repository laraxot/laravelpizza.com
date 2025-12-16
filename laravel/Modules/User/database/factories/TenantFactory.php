<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\User\Models\Tenant;

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
            'slug' => Str::slug($name),
            'domain' => $this->faker->domainName(),
            'database' => $this->faker->word(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
