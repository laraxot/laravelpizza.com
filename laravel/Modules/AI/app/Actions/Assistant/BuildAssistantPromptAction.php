<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Assistant;

use Modules\AI\Models\AiKnowledgeEntry;
use Spatie\QueueableAction\QueueableAction;

/**
 * Costruisce system prompt e prompt utente dell'assistente.
 *
 * Il modello puo' usare SOLO le fonti passate: se non bastano deve chiedere l'intervento
 * di una persona invece di inventare. Le regole sono fisse (non configurabili) perche'
 * valgono per tutti i progetti.
 */
final class BuildAssistantPromptAction
{
    use QueueableAction;

    public const string SYSTEM_PROMPT = <<<'PROMPT'
        You are a customer support assistant. Rules you must always follow:
        1. Answer ONLY with information contained in the SOURCES. Never invent policies, prices, dates or deadlines.
        2. If the SOURCES do not contain the answer, set "handoff" to true.
        3. Never promise refunds, compensations or exceptions; never give legal or medical advice: set "handoff" to true.
        4. If the customer is angry or the request is complex, set "handoff" to true.
        5. Answer in the same language as the QUESTION, briefly and politely.
        6. Reply ONLY with valid JSON: {"answer": string, "handoff": boolean, "reason": string|null, "source_ids": int[]}
        PROMPT;

    /** @param  list<AiKnowledgeEntry>  $entries */
    public function execute(string $question, array $entries): string
    {
        $sources = array_map(
            static fn (AiKnowledgeEntry $entry): string => sprintf(
                "[id=%d]\nQ: %s\nA: %s",
                $entry->id,
                $entry->question,
                $entry->answer,
            ),
            $entries,
        );

        return "SOURCES:\n".implode("\n\n", $sources)."\n\nQUESTION:\n".$question;
    }
}
