<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Modules\AI\Enums\AiActionProposalStatusEnum;
use Modules\AI\Models\AiActionProposal;
use Spatie\QueueableAction\QueueableAction;

/**
 * Cancels a pending `AiActionProposal` without executing it.
 */
class CancelAiActionProposalAction
{
    use QueueableAction;

    public function execute(AiActionProposal $proposal): AiActionProposal
    {
        $proposal->forceFill([
            'status' => AiActionProposalStatusEnum::CANCELLED,
        ])->save();

        return $proposal;
    }
}
