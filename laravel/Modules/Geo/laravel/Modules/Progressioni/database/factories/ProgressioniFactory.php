<?php

declare(strict_types=1);

namespace Modules\Progressioni\Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Progressioni\Models\Progressioni;

/**
 * @extends Factory<Progressioni>
 */
class ProgressioniFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Progressioni>
     */
    protected $model = Progressioni::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $anno = $this->faker->numberBetween(2020, 2025);

        return [
            'post_type' => 'progressioni',
            'ente' => $this->faker->numberBetween(1, 5),
            'matr' => $this->faker->unique()->numberBetween(1000, 9999),
            'cognome' => $this->faker->lastName(),
            'nome' => $this->faker->firstName(),
            'email' => $this->faker->safeEmail(),
            'propro' => $this->faker->numberBetween(1, 5),
            'posfun' => $this->faker->numberBetween(1, 5),
            'categoria_eco' => $this->faker->randomElement(['B1', 'B2', 'C1', 'C2', 'D1', 'D2']),
            'posiz' => $this->faker->numberBetween(1, 3),
            'stabi' => $this->faker->numberBetween(1, 10),
            'stabi_txt' => $this->faker->word(),
            'repar' => $this->faker->numberBetween(1, 20),
            'repar_txt' => $this->faker->word(),
            'gg_in_sede' => $this->faker->numberBetween(150, 250),
            'gg_fuori_sede' => $this->faker->numberBetween(0, 50),
            'gg_presenza_anno' => $this->faker->numberBetween(180, 300),
            'gg_assenza_anno' => $this->faker->numberBetween(0, 30),
            'gg_anno' => 365,
            'gg_cateco_posfun' => $this->faker->numberBetween(150, 300),
            'anno' => $anno,
            'ha_diritto' => $this->faker->randomElement([0, 1]),
            'motivo' => $this->faker->optional(0.3)->sentence(),
            'refreshed_at' => $this->faker->optional(0.7)->dateTimeBetween('-30 days', 'now'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'created_by' => 'test',
            'updated_by' => 'test',
            'excellences_count_last_3_years' => $this->faker->numberBetween(0, 3),
            'perf_ind_count_last_3_years' => $this->faker->numberBetween(0, 3),
        ];
    }

    /**
     * Define a state where the model has rights.
     */
    public function withRights(): static
    {
        return $this->state(fn (array $attributes) => [
            'ha_diritto' => 1,
            'motivo' => null,
        ]);
    }

    /**
     * Define a state where the model doesn't have rights.
     */
    public function withoutRights(): static
    {
        return $this->state(fn (array $attributes) => [
            'ha_diritto' => 0,
            'motivo' => $this->faker->sentence(),
        ]);
    }

    /**
     * Define a state where the model has never been refreshed.
     */
    public function neverRefreshed(): static
    {
        return $this->state(fn (array $attributes) => [
            'refreshed_at' => null,
        ]);
    }

    /**
     * Define a state where the model was refreshed recently (within the last day).
     */
    public function recentlyRefreshed(): static
    {
        return $this->state(fn (array $attributes) => [
            'refreshed_at' => Carbon::now()->subHours(12),
        ]);
    }

    /**
     * Define a state where the model was refreshed a while ago (more than one day).
     */
    public function oldRefreshed(): static
    {
        return $this->state(fn (array $attributes) => [
            'refreshed_at' => Carbon::now()->subDays(5),
        ]);
    }
}
