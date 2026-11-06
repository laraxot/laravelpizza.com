<?php

declare(strict_types=1);

namespace Modules\AI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AI\Models\AiThread;

/** @extends Factory<AiThread> */
class AiThreadFactory extends Factory
{
    /** @var class-string<AiThread> */
    protected $model = AiThread::class;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'public_id' => $this->faker->unique()->uuid(),
            'created_by_user_id' => $this->faker->numberBetween(1, 50),
            'panel_id' => $this->faker->randomElement(['operator', 'admin']),
            'last_message_at' => $this->faker->optional()->dateTimeBetween('-1 week', 'now'),
            'meta' => $this->faker->optional()->passthrough(['locale' => $this->faker->languageCode()]),
        ];
    }
}
