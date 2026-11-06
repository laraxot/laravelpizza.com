<?php

declare(strict_types=1);

namespace Modules\AI\Contracts;

use Modules\AI\Models\AiActionProposal;
use Modules\AI\Adapters\AiActionHandlerRegistry;

/**
 * Contract for a handler capable of executing a specific type of
 * `AiActionProposal` once it has been confirmed by a human.
 *
 * Implementations are registered against a proposal `type` string
 * (e.g. `start_time_punch`, `change_work_order_status`) via
 * {@see AiActionHandlerRegistry}.
 */
interface AiActionHandlerContract
{
    /**
     * The proposal `type` this handler is responsible for.
     */
    public function type(): string;

    /**
     * Execute the confirmed proposal and return a result payload.
     *
     * @return array<string, mixed>
     */
    public function handle(AiActionProposal $proposal): array;
}
