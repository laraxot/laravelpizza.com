<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Assistant;

use Illuminate\Support\Facades\Log;
use Modules\AI\Actions\AppendAiMessageAction;
use Modules\AI\Actions\CreateAiActionProposalAction;
use Modules\AI\Adapters\AssistantHandoffHandler;
use Modules\AI\Datas\AssistantAnswerData;
use Modules\AI\Enums\AiMessageRoleEnum;
use Modules\AI\Models\AiKnowledgeEntry;
use Modules\AI\Models\AiThread;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

/**
 * Risponde a una domanda di un cliente usando solo la base di conoscenza della `collection`.
 *
 * Flusso: guardrail deterministico -> ricerca fonti -> modello (solo fonti) -> risposta.
 * Ogni volta che non c'e' una risposta sicura (argomento sensibile, nessuna fonte, modello
 * incerto o non raggiungibile) crea una AiActionProposal `assistant_handoff`: la coda delle
 * proposte in Filament diventa la coda delle richieste da gestire a mano.
 *
 * Domanda e risposta restano in AiThread/AiMessage: sono la base del report settimanale.
 */
final class AnswerQuestionAction
{
    use QueueableAction;

    public const string PAYLOAD_KIND = 'assistant_answer';

    public function __construct(
        private readonly DetectHandoffTriggerAction $detectHandoff,
        private readonly SearchKnowledgeEntriesAction $search,
        private readonly BuildAssistantPromptAction $buildPrompt,
        private readonly RequestAssistantCompletionAction $request,
        private readonly CreateAiActionProposalAction $createProposal,
        private readonly AppendAiMessageAction $appendMessage,
    ) {}

    /**
     * @param  int|string|null  $userId  null = visitatore anonimo; intero o UUID
     * @param  list<string>|null  $handoffKeywords  parole che passano subito a una persona; null = config
     */
    public function execute(
        AiThread $thread,
        string $collection,
        string $question,
        int|string|null $userId = null,
        ?array $handoffKeywords = null,
    ): AssistantAnswerData {
        $this->appendMessage->execute($thread, AiMessageRoleEnum::USER, $question, $userId);

        $answer = $this->answer($collection, $question, $handoffKeywords);

        $this->appendMessage->execute($thread, AiMessageRoleEnum::ASSISTANT, $answer->answer, null, [
            'kind' => self::PAYLOAD_KIND,
            'collection' => $collection,
            'question' => $question,
            'needs_human' => $answer->needsHuman,
            'handoff_reason' => $answer->handoffReason,
            'source_ids' => $answer->sourceIds,
        ]);

        if ($answer->needsHuman) {
            $this->createProposal->execute(
                thread: $thread,
                proposedByUserId: $userId ?? $thread->created_by_user_id,
                type: AssistantHandoffHandler::TYPE,
                payload: [
                    'collection' => $collection,
                    'question' => $question,
                    'reason' => $answer->handoffReason,
                ],
                preview: $question,
            );
        }

        return $answer;
    }

    /** @param  list<string>|null  $handoffKeywords */
    private function answer(string $collection, string $question, ?array $handoffKeywords): AssistantAnswerData
    {
        $trigger = $this->detectHandoff->execute($question, $handoffKeywords);
        if ($trigger !== null) {
            return AssistantAnswerData::handoff('sensitive_topic:'.$trigger);
        }

        $maxSources = config('ai.assistant.max_sources', 5);
        $entries = $this->search->execute($collection, $question, is_numeric($maxSources) ? (int) $maxSources : 5);
        if ($entries === []) {
            return AssistantAnswerData::handoff('no_knowledge');
        }

        try {
            $raw = $this->request->execute(
                BuildAssistantPromptAction::SYSTEM_PROMPT,
                $this->buildPrompt->execute($question, $entries),
            );
        } catch (Throwable $throwable) {
            // Il supporto non deve mai rompersi: se il modello non risponde, passa a una persona.
            Log::warning('AI assistant unavailable', ['collection' => $collection, 'error' => $throwable->getMessage()]);

            return AssistantAnswerData::handoff('ai_unavailable');
        }

        return AssistantAnswerData::fromModelResponse(
            $raw,
            array_map(static fn (AiKnowledgeEntry $entry): int => $entry->id, $entries),
        );
    }
}
