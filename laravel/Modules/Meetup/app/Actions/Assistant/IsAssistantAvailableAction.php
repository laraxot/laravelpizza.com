<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Assistant;

use Modules\AI\Actions\Agent\ResolveAgentProviderAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * L'assistente si mostra solo se c'è un fornitore AI configurato (GROQ_API_KEY o OPENROUTER_API_KEY): senza, il
 * pulsante della chat non compare invece di offrire qualcosa che risponderebbe solo con un errore.
 */
class IsAssistantAvailableAction
{
    use QueueableAction;

    public function execute(): bool
    {
        try {
            app(ResolveAgentProviderAction::class)->execute();

            return true;
        } catch (\Throwable) {
            return false;
        }
    }
}
