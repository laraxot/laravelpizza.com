<?php

declare(strict_types=1);

namespace Modules\User\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\User\Models\Team;
use Modules\User\Models\User;

/**
 * @extends Factory<Team>
 */
class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Team>
     */
    protected $model = Team::class;

    /**
     * @return array<string, mixed>
     */
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'personal_team' => 0,
            'user_id' => User::factory(),
            'uuid' => (string) Str::uuid(),
        ];
    }
}
