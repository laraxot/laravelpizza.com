<?php

declare(strict_types=1);

namespace Modules\AI\Adapters;

use Illuminate\Support\Carbon;
use Modules\AI\Contracts\AiActionHandlerContract;
use Modules\AI\Models\AiActionProposal;

/**
 * Handler della proposta `assistant_handoff`: "confermare" significa che un operatore
 * ha preso in carico la domanda che l'assistente non poteva gestire da solo.
 *
 * Registrato di default in AIServiceProvider, cosi' la conferma dalla coda Filament non
 * finisce in `failed` per handler mancante. Un progetto puo' sostituirlo registrando un
 * proprio handler con lo stesso tipo (es. per aprire un ticket nel suo dominio).
 */
final class AssistantHandoffHandler implements AiActionHandlerContract
{
    public const string TYPE = 'assistant_handoff';

    public function type(): string
    {
        return self::TYPE;
    }

    /** @return array<string, mixed> */
    public function handle(AiActionProposal $proposal): array
    {
        return [
            'taken_in_charge_by_user_id' => $proposal->confirmed_by_user_id,
            'taken_in_charge_at' => Carbon::now()->toIso8601String(),
        ];
    }
}
