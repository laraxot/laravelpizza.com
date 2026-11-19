<?php

declare(strict_types=1);

namespace Modules\AI\Datas;

use Spatie\LaravelData\Data;

/**
 * Report dell'assistente su un periodo: cosa chiedono i clienti e dove serve una persona.
 *
 * `topSourceIds` (id voce => quante volte usata) mostra le domande piu' frequenti: spesso
 * la causa si risolve alla radice (pagina poco chiara, tabella taglie confusa...).
 * `unansweredQuestions` indica cosa aggiungere alla base di conoscenza.
 */
class AssistantReportData extends Data
{
    /**
     * @param  array<int, int>  $topSourceIds
     * @param  array<string, int>  $handoffReasons
     * @param  list<string>  $unansweredQuestions
     */
    public function __construct(
        public int $questions,
        public int $answered,
        public int $handoffs,
        public array $topSourceIds,
        public array $handoffReasons,
        public array $unansweredQuestions,
    ) {}

    /**
     * Aggrega i payload dei messaggi assistente (vedi AnswerQuestionAction::PAYLOAD_KIND).
     *
     * @param  iterable<array<string, mixed>>  $payloads
     */
    public static function fromAnswerPayloads(iterable $payloads): self
    {
        $questions = 0;
        $handoffs = 0;
        $topSourceIds = [];
        $handoffReasons = [];
        $unanswered = [];

        foreach ($payloads as $payload) {
            $questions++;

            if (($payload['needs_human'] ?? false) === true) {
                $handoffs++;
                $reason = is_string($payload['handoff_reason'] ?? null) ? $payload['handoff_reason'] : 'unknown';
                $handoffReasons[$reason] = ($handoffReasons[$reason] ?? 0) + 1;
                if ($reason === 'no_knowledge' && is_string($payload['question'] ?? null)) {
                    $unanswered[] = $payload['question'];
                }

                continue;
            }

            $sourceIds = is_array($payload['source_ids'] ?? null) ? $payload['source_ids'] : [];
            foreach ($sourceIds as $id) {
                if (is_int($id)) {
                    $topSourceIds[$id] = ($topSourceIds[$id] ?? 0) + 1;
                }
            }
        }

        arsort($topSourceIds);
        arsort($handoffReasons);

        return new self(
            questions: $questions,
            answered: $questions - $handoffs,
            handoffs: $handoffs,
            topSourceIds: $topSourceIds,
            handoffReasons: $handoffReasons,
            unansweredQuestions: array_values(array_unique($unanswered)),
        );
    }
}
