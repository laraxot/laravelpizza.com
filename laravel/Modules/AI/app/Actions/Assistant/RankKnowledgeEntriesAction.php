<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Assistant;

use Modules\AI\Models\AiKnowledgeEntry;
use Spatie\QueueableAction\QueueableAction;

/**
 * Ordina le voci della base di conoscenza per pertinenza rispetto a una domanda.
 *
 * KISS: sovrapposizione di parole (domanda e tag valgono doppio rispetto alla risposta).
 * Basta per basi di conoscenza piccole (decine/centinaia di voci); quando servira' la ricerca
 * semantica si sostituisce solo questa Action (embeddings), il resto non cambia.
 */
final class RankKnowledgeEntriesAction
{
    use QueueableAction;

    private const int QUESTION_WEIGHT = 2;

    public function __construct(private readonly TokenizeTextAction $tokenize) {}

    /**
     * @param  iterable<AiKnowledgeEntry>  $entries
     * @return list<AiKnowledgeEntry> solo le voci pertinenti, dalla piu' pertinente
     */
    public function execute(string $question, iterable $entries, int $limit = 5): array
    {
        $questionTokens = $this->tokenize->execute($question);
        if ($questionTokens === []) {
            return [];
        }

        $scored = [];
        foreach ($entries as $entry) {
            $score = $this->score($questionTokens, $entry);
            if ($score > 0) {
                $scored[] = ['entry' => $entry, 'score' => $score];
            }
        }

        usort($scored, static fn (array $a, array $b): int => $b['score'] <=> $a['score']);

        return array_map(
            static fn (array $item): AiKnowledgeEntry => $item['entry'],
            array_slice($scored, 0, $limit),
        );
    }

    /** @param  list<string>  $questionTokens */
    private function score(array $questionTokens, AiKnowledgeEntry $entry): int
    {
        $headline = $this->tokenize->execute($entry->question.' '.implode(' ', $entry->tags ?? []));
        $body = $this->tokenize->execute($entry->answer);

        return self::QUESTION_WEIGHT * count(array_intersect($questionTokens, $headline))
            + count(array_intersect($questionTokens, $body));
    }
}
