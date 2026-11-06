<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Mockery;
use Modules\AI\Actions\CompletionAction;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Resources\Completions;
use OpenAI\Responses\Completions\CreateResponse;
use PHPUnit\Framework\Assert;

uses(\Modules\AI\Tests\TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('Completion Action', function (): void {
    test('_creates_completion_with_valid_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = 'Explain what PHP is';
        $expectedText = 'PHP is a server-side scripting language designed for web development.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 5, 'completion_tokens' => 20, 'total_tokens' => 25],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, fn (string $method, array $parameters): bool => $method === 'create' && $parameters === [
            'model' => 'gpt-3.5-turbo-instruct',
            'prompt' => $prompt,
            'temperature' => 0.5,
            'max_tokens' => 100,
            'top_p' => 1.0,
            'frequency_penalty' => 0.0,
            'presence_penalty' => 0.0,
        ]);

        Assert::assertSame($expectedText, $result->text);
        Assert::assertSame(5, $result->promptTokens);
        Assert::assertSame(20, $result->completionTokens);
        Assert::assertSame(25, $result->totalTokens);
    });

    test('_handles_empty_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = '';
        $expectedText = 'No prompt provided.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 0, 'completion_tokens' => 5, 'total_tokens' => 5],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_long_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = str_repeat('This is a very long prompt that tests the handling of extended text content. ', 50);
        $expectedText = 'Response to long prompt.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 250, 'completion_tokens' => 10, 'total_tokens' => 260],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
        Assert::assertSame(250, $result->promptTokens);
    });

    test('_handles_special_characters_in_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = 'What is the meaning of life? 42! @#$%^&*()';
        $expectedText = 'The meaning of life is a philosophical question.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 15, 'completion_tokens' => 12, 'total_tokens' => 27],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_multilingual_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = '¿Qué es PHP? Explain in Spanish and English.';
        $expectedText = 'PHP es un lenguaje de programación. PHP is a programming language.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 12, 'completion_tokens' => 18, 'total_tokens' => 30],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_code_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = 'Write a PHP function to calculate factorial: function factorial($n) {';
        $expectedText = 'return $n <= 1 ? 1 : $n * factorial($n - 1); }';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 20, 'completion_tokens' => 25, 'total_tokens' => 45],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_technical_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = 'Explain the SOLID principles in software development.';
        $expectedText = 'SOLID principles are five design principles for object-oriented programming.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 10, 'completion_tokens' => 15, 'total_tokens' => 25],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_question_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = 'What are the best practices for Laravel development?';
        $expectedText = 'Laravel best practices include using Eloquent ORM, following PSR standards, and implementing proper validation.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 12, 'completion_tokens' => 22, 'total_tokens' => 34],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_creative_prompt', function (): void {
        $action = new CompletionAction;
        $prompt = 'Write a short story about a developer who discovers a magical bug.';
        $expectedText = 'Once upon a time, there was a developer named Alex who found a bug that glowed with an otherworldly light.';

        $mockResponse = CreateResponse::fake([
            'choices' => [['text' => $expectedText]],
            'usage' => ['prompt_tokens' => 15, 'completion_tokens' => 30, 'total_tokens' => 45],
        ]);

        $openAi = OpenAI::fake([$mockResponse]);

        $result = $action->execute($prompt);

        $openAi->assertSent(Completions::class, 1);

        Assert::assertSame($expectedText, $result->text);
    });
});
