<?php

declare(strict_types=1);

namespace Modules\AI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Esito di una chiamata a tool dell'assistente AI registrata in AiToolLog (audit trail).
 *
 * Label/colore/icona arrivano da `ai::ai_tool_log_status_enum.values.<valore>.*` (EnumTrait).
 */
enum AiToolLogStatusEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case OK = 'ok';
    case ERROR = 'error';

    public function isError(): bool
    {
        return $this === self::ERROR;
    }
}
