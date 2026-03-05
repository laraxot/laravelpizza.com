<?php

declare(strict_types=1);

namespace Modules\Meetup\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Meetup\Models\Performer;

/**
 * @extends Factory<Performer>
 */
class PerformerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Performer>
     */
    protected $model = Performer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(['speaker', 'host', 'moderator', 'performer']),
            'bio' => $this->faker->paragraph(),
            'photo' => $this->faker->imageUrl(),
            'website' => $this->faker->url(),
            'email' => $this->faker->unique()->safeEmail(),
            'company' => $this->faker->company(),
            'twitter' => '@'.$this->faker->username(),
            'linkedin' => $this->faker->username(),
            'github' => $this->faker->username(),
            'meta_data' => [
                'verified' => $this->faker->boolean(),
                'rating' => $this->faker->randomFloat(2, 0, 5),
            ],
        ];
    }
}

