<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Illuminate\Support\Carbon;
use Modules\AI\Enums\AiMessageRoleEnum;
use Modules\AI\Models\AiMessage;
use Modules\AI\Models\AiThread;
use Spatie\QueueableAction\QueueableAction;

/**
 * Aggiunge un messaggio a un thread e ne aggiorna `last_message_at`.
 *
 * Usata dall'assistente e dai progetti per i messaggi che non passano dal modello
 * (es. domanda arrivata quando la conversazione e' gia' in mano a una persona, risposta di un operatore).
 */
final class AppendAiMessageAction
{
    use QueueableAction;

    /** @param  array<string, mixed>|null  $payload */
    public function execute(
        AiThread $thread,
        AiMessageRoleEnum $role,
        string $content,
        int|string|null $userId = null,
        ?array $payload = null,
    ): AiMessage {
        $message = new AiMessage;
        $message->fill([
            'ai_thread_id' => $thread->getKey(),
            'user_id' => $userId === null ? null : (string) $userId,
            'role' => $role,
            'content' => $content,
            'payload' => $payload,
        ]);
        $message->save();

        $thread->forceFill(['last_message_at' => Carbon::now()])->save();

        return $message;
    }
}
