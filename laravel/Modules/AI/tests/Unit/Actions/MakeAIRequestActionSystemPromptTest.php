<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Modules\AI\Actions\MakeAIRequestAction;
use Modules\AI\Tests\TestCase;

uses(TestCase::class);

test('_uses_the_historic_system_prompt_by_default_and_the_given_one_when_passed', function (): void {
    Http::fake(['*' => Http::response(['choices' => [['message' => ['content' => '{}']]]])]);

    (new MakeAIRequestAction)->execute('prompt', 'classification');
    (new MakeAIRequestAction)->execute('prompt', 'assistant', [], 'Custom system prompt');

    $firstMessageContent = function (Request $request): mixed {
        $messages = $request->data()['messages'] ?? null;
        $first = is_array($messages) ? ($messages[0] ?? null) : null;

        return is_array($first) ? ($first['content'] ?? null) : null;
    };

    Http::assertSent(fn (Request $request): bool => $firstMessageContent($request) === MakeAIRequestAction::DEFAULT_SYSTEM_PROMPT);
    Http::assertSent(fn (Request $request): bool => $firstMessageContent($request) === 'Custom system prompt');
});
