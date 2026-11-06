<?php

declare(strict_types=1);

namespace Modules\AI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Ciclo di vita di una AiActionProposal (azione proposta dall'AI, soggetta a conferma umana).
 *
 * pending -> confirmed -> executed
 *        \-> cancelled
 *        \-> failed
 *
 * Label/colore/icona arrivano da `ai::ai_action_proposal_status_enum.values.<valore>.*` (EnumTrait).
 */
enum AiActionProposalStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case PENDING = 'pending';
    case CANCELLED = 'cancelled';
    case CONFIRMED = 'confirmed';
    case EXECUTED = 'executed';
    case FAILED = 'failed';

    public function isPending(): bool
    {
        return $this === self::PENDING;
    }

    /** Stato terminale: la proposta non e' piu' in attesa di decisione umana. */
    public function isFinal(): bool
    {
        return ! $this->isPending();
    }

    public function canBeConfirmed(): bool
    {
        return $this->isPending();
    }

    public function canBeCancelled(): bool
    {
        return $this->isPending();
    }
}
