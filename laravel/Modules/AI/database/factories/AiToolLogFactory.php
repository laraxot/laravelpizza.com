<?php

declare(strict_types=1);

namespace Modules\AI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AI\Enums\AiToolLogStatusEnum;
use Modules\AI\Models\AiToolLog;

/**
 * @extends Factory<AiToolLog>
 */
class AiToolLogFactory extends Factory
{
    /** @var class-string<AiToolLog> */
    protected $model = AiToolLog::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ai_thread_id' => AiThreadFactory::new()->createOne()->getKey(),
            'ai_action_proposal_id' => null,
            'user_id' => $this->faker->optional()->numberBetween(1, 50),
            'tool_name' => $this->faker->randomElement(['list_work_orders', 'get_work_order', 'search_customers']),
            'arguments' => ['query' => $this->faker->word()],
            'response' => ['ok' => true],
            'status' => AiToolLogStatusEnum::OK,
            'error' => null,
        ];
    }
}
