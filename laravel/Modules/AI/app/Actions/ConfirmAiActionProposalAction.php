<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Illuminate\Support\Carbon;
use Modules\AI\Enums\AiActionProposalStatusEnum;
use Modules\AI\Models\AiActionProposal;
use Modules\AI\Adapters\AiActionHandlerRegistry;
use Spatie\QueueableAction\QueueableAction;

/**
 * Confirms a pending `AiActionProposal` and immediately executes it via the
 * handler registered in {@see AiActionHandlerRegistry} for its `type`.
 *
 * On success the proposal is marked `executed`, on failure `failed` with the
 * error message stored for audit/debugging.
 */
class ConfirmAiActionProposalAction
{
    use QueueableAction;

    public function __construct(private readonly AiActionHandlerRegistry $registry) {}

    public function execute(AiActionProposal $proposal, int $confirmedByUserId): AiActionProposal
    {
        $proposal->forceFill([
            'status' => AiActionProposalStatusEnum::CONFIRMED,
            'confirmed_by_user_id' => $confirmedByUserId,
            'confirmed_at' => Carbon::now(),
        ])->save();

        $handler = $this->registry->get($proposal->type);

        if ($handler === null) {
            $proposal->forceFill([
                'status' => AiActionProposalStatusEnum::FAILED,
                'error' => "No AiActionHandler registered for type [{$proposal->type}].",
            ])->save();

            return $proposal;
        }

        try {
            $result = $handler->handle($proposal);

            $proposal->forceFill([
                'status' => AiActionProposalStatusEnum::EXECUTED,
                'executed_at' => Carbon::now(),
                'result' => $result,
            ])->save();
        } catch (\Throwable $throwable) {
            $proposal->forceFill([
                'status' => AiActionProposalStatusEnum::FAILED,
                'error' => $throwable->getMessage(),
            ])->save();
        }

        return $proposal;
    }
}
