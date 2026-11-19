<?php

declare(strict_types=1);

namespace Modules\AI\Actions\Assistant;

use Illuminate\Validation\ValidationException;
use Modules\AI\Models\AiKnowledgeEntry;
use Spatie\QueueableAction\QueueableAction;

/**
 * Crea o aggiorna una voce della base di conoscenza di una `collection`.
 *
 * Con `$id` aggiorna la voce solo se appartiene alla stessa collection (un chiamante non puo'
 * modificare la base di conoscenza di un altro progetto o cliente passando un id qualsiasi).
 * Senza `$id`, una voce con la stessa domanda nella collection viene aggiornata invece di duplicata.
 */
final class SaveKnowledgeEntryAction
{
    use QueueableAction;

    /** @param  list<string>|null  $tags */
    public function execute(
        string $collection,
        string $question,
        string $answer,
        ?array $tags = null,
        ?int $id = null,
        bool $isActive = true,
    ): AiKnowledgeEntry {
        $question = trim($question);
        $answer = trim($answer);

        if ($question === '' || $answer === '') {
            throw ValidationException::withMessages(['question' => 'Domanda e risposta sono obbligatorie.']);
        }

        $entry = $id !== null
            ? AiKnowledgeEntry::query()->where('collection', $collection)->whereKey($id)->first()
            : AiKnowledgeEntry::query()->where('collection', $collection)->where('question', $question)->first();

        if ($id !== null && ! $entry instanceof AiKnowledgeEntry) {
            throw ValidationException::withMessages(['id' => 'Voce non trovata in questa base di conoscenza.']);
        }

        $entry ??= new AiKnowledgeEntry;
        $entry->fill([
            'collection' => $collection,
            'question' => $question,
            'answer' => $answer,
            'tags' => $tags === null ? $entry->tags : array_values(array_filter($tags, static fn (string $tag): bool => trim($tag) !== '')),
            'is_active' => $isActive,
        ]);
        $entry->save();

        return $entry;
    }
}
