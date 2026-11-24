<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Assistant;

use Illuminate\Validation\ValidationException;
use Modules\AI\Actions\Assistant\SaveKnowledgeEntryAction;
use Modules\AI\Tests\TestCase;

uses(TestCase::class);

test('_refuses_an_empty_question_or_answer_before_touching_the_database', function (string $question, string $answer): void {
    app(SaveKnowledgeEntryAction::class)->execute('demo', $question, $answer);
})->with([
    'domanda vuota' => ['  ', 'Risposta'],
    'risposta vuota' => ['Domanda?', "\n"],
<<<<<<< HEAD
])->throws(ValidationException::class)->group('AI-KNOWLEDGE-INV-1');
=======
])->throws(ValidationException::class);
>>>>>>> eab1d98 (chore(AI): sync working tree (docs, phpstan fixes, wip))
