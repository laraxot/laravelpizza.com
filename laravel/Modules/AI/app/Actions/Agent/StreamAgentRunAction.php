<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Agent;

use Generator;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Modules\AI\Neuron\Agents\XotBaseAgent;
use NeuronAI\Agent\Adapters\AGUIAdapter;
use NeuronAI\Agent\AgentState;
use NeuronAI\Agent\Frontend\AGUIInputTranslator;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\Workflow\Streaming\ProtocolEvent;
use NeuronAI\Workflow\Streaming\SSEEncoder;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

use function Safe\set_time_limit;

/**
 * Endpoint AG-UI agnostico: legge un RunAgentInput, fa girare l'agente e risponde in streaming (SSE).
 *
 * - Nuovo turno: conta solo l'ultimo messaggio dell'utente, la cronologia la tiene il server.
 * - `resume`: la decisione su un'azione in attesa di approvazione riprende il run in pausa.
 * - Il thread deve iniziare con `$threadPrefix` (es. `operator-{idUtente}-`): un utente parla solo nei suoi.
 *
 * Pattern da datomatic/laravelday-2026 (MIT), come Action invece che controller.
 */
final class StreamAgentRunAction
{
    use QueueableAction;

    public const int TIME_LIMIT = 180;

    public function execute(Request $request, XotBaseAgent $agent, string $threadPrefix): StreamedResponse
    {
        /** @var array{threadId: string, runId: string, messages: list<array<string, mixed>>, resume?: array<mixed>|null} $input */
        $input = Validator::validate($request->all(), [
            'threadId' => ['required', 'string', 'max:255'],
            'runId' => ['required', 'string', 'max:255'],
            'messages' => ['present', 'array'],
            'messages.*.id' => ['required', 'string'],
            'messages.*.role' => ['required', 'string'],
            'resume' => ['nullable', 'array'],
        ]);
        // validate() restituisce solo i campi con una regola: i messaggi vanno presi interi dalla richiesta, altrimenti
        // contenuto e chiamate ai tool spariscono e ogni turno risponde 422 "Nessun messaggio".
        /** @var list<array<string, mixed>> $messages */
        $messages = array_values(array_filter((array) $request->input('messages', []), 'is_array'));
        $input['messages'] = $messages;

        if (! str_starts_with($input['threadId'], $threadPrefix)) {
            throw new AccessDeniedHttpException('Conversazione di un altro utente.');
        }

        $isResume = ($input['resume'] ?? []) !== [];
        $prompt = $this->lastUserMessage($input['messages']);
        if (! $isResume && $prompt === null) {
            throw new HttpException(422, 'Nessun messaggio o decisione da elaborare.');
        }

        $adapter = new AGUIAdapter($input['threadId'], $input['runId'], $input['messages']);
        $agent = $agent->for($input['threadId'])->setStreamAdapter(static fn (): AGUIAdapter => $adapter);

        // Con lo stream adapter AG-UI gli eventi sono ProtocolEvent: neuron li tipizza solo come object.
        /** @var Generator<int, ProtocolEvent, mixed, AgentState> $events */
        $events = $isResume
            ? $agent->submitInputs($request->all(), new AGUIInputTranslator)->events()
            : $agent->stream(new UserMessage((string) $prompt));

        // Un turno puo' concatenare piu' chiamate al modello: 60 secondi spezzerebbero lo stream a meta'.
        // Solo nelle richieste web: da console (test, code) il limite varrebbe per tutto il processo e
        // fermerebbe una suite di test lunga dopo TIME_LIMIT secondi.
        if (! app()->runningInConsole()) {
            set_time_limit(self::TIME_LIMIT);
        }

        // Avvio subito: un run rifiutato (es. approvazione ancora in attesa) diventa un errore HTTP, non uno stream.
        $events->valid();

        return response()->stream(static function () use ($events, $adapter): Generator {
            try {
                yield from SSEEncoder::encode($events);
            } catch (Throwable $exception) {
                report($exception);

                foreach ($adapter->error($exception) as $event) {
                    yield SSEEncoder::frame($event);
                }
            }
        }, 200, $adapter->getHeaders());
    }

    /** @param  list<array<string, mixed>>  $messages */
    private function lastUserMessage(array $messages): ?string
    {
        $last = Arr::last($messages, static fn (array $message): bool => ($message['role'] ?? null) === 'user');
        $content = is_array($last) ? ($last['content'] ?? null) : null;

        return is_string($content) && trim($content) !== '' ? $content : null;
    }
}
