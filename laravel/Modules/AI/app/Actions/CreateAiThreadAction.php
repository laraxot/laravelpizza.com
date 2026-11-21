<?php

declare(strict_types=1);

namespace Modules\AI\Actions;

use Modules\AI\Models\AiThread;
use Ramsey\Uuid\Uuid;
use Spatie\QueueableAction\QueueableAction;

/**
 * Crea un thread di conversazione AI.
 *
 * `panelId` dice da dove arriva la conversazione (es. `operator`, `widget`): lo decide il chiamante.
 * `userId` null = visitatore anonimo; intero o UUID, salvato come stringa.
 */
final class CreateAiThreadAction
{
    use QueueableAction;

    /** @param  array<string, mixed>  $meta */
    public function execute(int|string|null $userId, string $panelId, array $meta = []): AiThread
    {
        $thread = new AiThread;
        $thread->fill([
            'public_id' => Uuid::uuid4()->toString(),
            'created_by_user_id' => $userId === null ? null : (string) $userId,
            'panel_id' => $panelId,
            'meta' => $meta === [] ? null : $meta,
        ]);
        $thread->save();

        return $thread;
    }
}
