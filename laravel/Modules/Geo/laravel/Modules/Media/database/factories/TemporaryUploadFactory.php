<?php

declare(strict_types=1);

namespace Modules\Media\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Media\Models\TemporaryUpload;

/**
 * TemporaryUpload Factory
 *
 * Factory for creating TemporaryUpload model instances for testing and seeding.
 *
 * @extends Factory<TemporaryUpload>
 */
class TemporaryUploadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TemporaryUpload>
     */
    protected $model = TemporaryUpload::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'session_id' => $this->faker->uuid(),
        ];
    }

    /**
     * Create temporary upload for a specific session.
     */
    public function forSession(string $sessionId): static
    {
        return $this->state(fn (array $_attributes): array => [
            'session_id' => $sessionId,
        ]);
    }

    /**
     * Create temporary upload for current session.
     */
    public function currentSession(): static
    {
        return $this->state(fn (array $_attributes): array => [
            'session_id' => session()->getId(),
        ]);
    }
}
