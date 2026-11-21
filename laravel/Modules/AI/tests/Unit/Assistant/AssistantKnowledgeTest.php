<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Assistant;

use Modules\AI\Actions\Assistant\BuildAssistantPromptAction;
use Modules\AI\Actions\Assistant\DetectHandoffTriggerAction;
use Modules\AI\Actions\Assistant\RankKnowledgeEntriesAction;
use Modules\AI\Actions\Assistant\TokenizeTextAction;
use Modules\AI\Models\AiKnowledgeEntry;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/** @param  list<string>  $tags */
function knowledgeEntry(int $id, string $question, string $answer, array $tags = []): AiKnowledgeEntry
{
    $entry = new AiKnowledgeEntry;
    $entry->forceFill(['id' => $id, 'collection' => 'demo', 'question' => $question, 'answer' => $answer, 'tags' => $tags, 'is_active' => true]);

    return $entry;
}

describe('TokenizeTextAction', function (): void {
    test('_normalizes_case_accents_punctuation_and_drops_short_words', function (): void {
        Assert::assertSame(
            ['quanto', 'costa', 'spedizione', 'citta'],
            app(TokenizeTextAction::class)->execute('Quanto costa la SPEDIZIONE in città?'),
        );
    });
});

describe('RankKnowledgeEntriesAction', function (): void {
    test('_puts_the_most_relevant_entry_first_and_drops_unrelated_ones', function (): void {
        $entries = [
            knowledgeEntry(1, 'Quali sono gli orari di apertura?', 'Dal lunedi al venerdi 9-18.'),
            knowledgeEntry(2, 'Quanto costa la spedizione?', 'La spedizione costa 5 euro, gratis sopra 50 euro.', ['consegna']),
            knowledgeEntry(3, 'Come faccio un reso?', 'Hai 30 giorni per il reso.'),
        ];

        $ranked = app(RankKnowledgeEntriesAction::class)->execute('costo spedizione e consegna?', $entries);

        Assert::assertSame([2], array_map(static fn (AiKnowledgeEntry $e): int => $e->id, $ranked));
    });

    test('_respects_the_limit', function (): void {
        $entries = [
            knowledgeEntry(1, 'reso prodotto', 'reso'),
            knowledgeEntry(2, 'reso ordine', 'reso'),
        ];

        Assert::assertCount(1, app(RankKnowledgeEntriesAction::class)->execute('reso', $entries, 1));
    });

    test('_returns_nothing_for_an_empty_question', function (): void {
        Assert::assertSame([], app(RankKnowledgeEntriesAction::class)->execute('?!', [knowledgeEntry(1, 'reso', 'reso')]));
    });
});

describe('DetectHandoffTriggerAction', function (): void {
    test('_is_off_when_the_project_configures_no_keywords', function (): void {
        config(['ai.assistant.handoff_keywords' => []]);

        Assert::assertNull(app(DetectHandoffTriggerAction::class)->execute('Voglio un rimborso subito'));
    });

    test('_matches_project_keywords_as_word_prefixes_ignoring_case_and_accents', function (): void {
        config(['ai.assistant.handoff_keywords' => ['Rimbors', 'avvocato']]);
        $detect = app(DetectHandoffTriggerAction::class);

        Assert::assertSame('rimbors', $detect->execute('Voglio i RIMBORSI!'));
        Assert::assertSame('avvocato', $detect->execute('Chiamo il mio avvocato'));
        Assert::assertNull($detect->execute('Quanto costa la spedizione?'));
    });

    test('_keywords_passed_by_the_caller_replace_the_config_ones', function (): void {
        config(['ai.assistant.handoff_keywords' => ['avvocato']]);
        $detect = app(DetectHandoffTriggerAction::class);

        Assert::assertSame('allerg', $detect->execute('Il piatto contiene ALLERGENI?', ['allerg']));
        Assert::assertNull($detect->execute('Chiamo il mio avvocato', ['allerg']));
        Assert::assertNull($detect->execute('Chiamo il mio avvocato', []));
    });
});

describe('BuildAssistantPromptAction', function (): void {
    test('_includes_sources_with_ids_and_the_question', function (): void {
        $prompt = app(BuildAssistantPromptAction::class)->execute('Fate consegne?', [
            knowledgeEntry(7, 'Consegnate a domicilio?', 'Si, entro 3 km.'),
        ]);

        Assert::assertStringContainsString('[id=7]', $prompt);
        Assert::assertStringContainsString('A: Si, entro 3 km.', $prompt);
        Assert::assertStringEndsWith("QUESTION:\nFate consegne?", $prompt);
        Assert::assertStringContainsString('ONLY with information contained in the SOURCES', BuildAssistantPromptAction::SYSTEM_PROMPT);
    });
});
