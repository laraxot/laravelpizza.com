<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Assistant;

use Modules\AI\Models\AiKnowledgeEntry;
use Spatie\QueueableAction\QueueableAction;

/**
 * Cerca nella base di conoscenza attiva di una `collection` le voci utili a rispondere.
 */
final class SearchKnowledgeEntriesAction
{
    use QueueableAction;

    public function __construct(private readonly RankKnowledgeEntriesAction $rank) {}

    /** @return list<AiKnowledgeEntry> */
    public function execute(string $collection, string $question, int $limit = 5): array
    {
        $entries = AiKnowledgeEntry::query()
            ->where('collection', $collection)
            ->where('is_active', true)
            ->get();

        return $this->rank->execute($question, $entries, $limit);
    }
}
