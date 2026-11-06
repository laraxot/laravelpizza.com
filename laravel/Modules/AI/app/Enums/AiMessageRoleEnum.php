<?php

declare(strict_types=1);

namespace Modules\AI\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\Xot\Traits\EnumTrait;

/**
 * Autore di un AiMessage all'interno di un AiThread (user|assistant|tool|system).
 *
 * I valori coincidono con il campo `role` dei payload chat-completion.
 * Label/colore/icona arrivano da `ai::ai_message_role_enum.values.<valore>.*` (EnumTrait).
 */
enum AiMessageRoleEnum: string implements HasColor, HasIcon, HasLabel
{
    use EnumTrait;

    case USER = 'user';
    case ASSISTANT = 'assistant';
    case TOOL = 'tool';
    case SYSTEM = 'system';

    /** Solo i messaggi dell'utente hanno un `user_id` associato. */
    public function isUser(): bool
    {
        return $this === self::USER;
    }
}
