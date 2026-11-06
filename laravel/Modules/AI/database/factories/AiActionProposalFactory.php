<?php

declare(strict_types=1);

namespace Modules\AI\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AI\Enums\AiActionProposalStatusEnum;
use Modules\AI\Models\AiActionProposal;

/**
 * @extends Factory<AiActionProposal>
 */
class AiActionProposalFactory extends Factory
{
    /** @var class-string<AiActionProposal> */
    protected $model = AiActionProposal::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'public_id' => $this->faker->unique()->uuid(),
            'ai_thread_id' => AiThreadFactory::new()->createOne()->getKey(),
            'proposed_by_user_id' => $this->faker->numberBetween(1, 50),
            'type' => $this->faker->randomElement(['create_work_order', 'update_status', 'assign_operator']),
            'payload' => ['reason' => $this->faker->sentence()],
            'preview' => $this->faker->optional()->sentence(),
            'status' => AiActionProposalStatusEnum::PENDING,
            'confirmed_by_user_id' => null,
            'confirmed_at' => null,
            'executed_at' => null,
            'result' => null,
            'error' => null,
        ];
    }
}
