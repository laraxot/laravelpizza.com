<?php

declare(strict_types=1);

namespace Modules\AI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AI\Enums\AiMessageRoleEnum;
use Modules\AI\Models\AiMessage;

/**
 * @extends Factory<AiMessage>
 */
class AiMessageFactory extends Factory
{
    /** @var class-string<AiMessage> */
    protected $model = AiMessage::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = AiMessageRoleEnum::cases();
        $role = $roles[$this->faker->numberBetween(0, count($roles) - 1)];

        return [
            'ai_thread_id' => AiThreadFactory::new()->createOne()->getKey(),
            'user_id' => $role->isUser() ? $this->faker->numberBetween(1, 50) : null,
            'role' => $role,
            'content' => $this->faker->sentence(),
            'payload' => null,
        ];
    }
}
