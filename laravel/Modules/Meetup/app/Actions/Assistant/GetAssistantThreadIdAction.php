<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Assistant;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * Id della conversazione con l'assistente: uno per sessione, legato all'utente (prefisso "meetup-{id}-").
 * Lo crea il server, così il browser non può scegliere il thread di un altro; `fresh` ne apre uno nuovo.
 */
class GetAssistantThreadIdAction
{
    use QueueableAction;

    private const string SESSION_KEY = 'meetup.assistant.thread';

    public function execute(string $userId, bool $fresh = false): string
    {
        $prefix = RunMeetupAssistantAction::threadPrefix($userId);
        $current = session(self::SESSION_KEY);

        if (! $fresh && is_string($current) && str_starts_with($current, $prefix)) {
            return $current;
        }

        $thread = $prefix.Str::uuid()->toString();
        session([self::SESSION_KEY => $thread]);

        return $thread;
    }
}
