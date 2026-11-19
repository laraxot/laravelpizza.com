<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Assistant;

use Illuminate\Http\Request;
use Modules\AI\Actions\Agent\StreamAgentRunAction;
use Modules\AI\Exceptions\AiRequestException;
use Modules\Meetup\Neuron\Agents\MeetupAssistant;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * Endpoint AG-UI dell'assistente (POST /meetup/assistant, rotta in Modules/Meetup/routes/web.php).
 * Ogni utente parla solo nei suoi thread: prefisso "meetup-{id}-" controllato da StreamAgentRunAction.
 */
class RunMeetupAssistantAction
{
    public function __invoke(Request $request): StreamedResponse
    {
        $user = $request->user();
        $userId = $user?->getAuthIdentifier();
        if (! is_string($userId) && ! is_int($userId)) {
            throw new UnauthorizedHttpException('Session');
        }

        try {
            return app(StreamAgentRunAction::class)->execute(
                $request,
                app(MeetupAssistant::class),
                self::threadPrefix((string) $userId),
            );
        } catch (AiRequestException $exception) {
            // Nessun fornitore configurato: 503 con un messaggio chiaro, non un errore 500.
            report($exception);

            throw new ServiceUnavailableHttpException(null, (string) __('meetup::assistant.unavailable'), $exception);
        }
    }

    public static function threadPrefix(string $userId): string
    {
        return 'meetup-'.$userId.'-';
    }
}
