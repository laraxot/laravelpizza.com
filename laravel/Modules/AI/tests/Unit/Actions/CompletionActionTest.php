<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Mockery;
use Modules\AI\Actions\CompletionAction;
use Modules\AI\Datas\CompletionData;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Completions\CreateResponse;
use OpenAI\Responses\Completions\CreateResponseChoice;
use OpenAI\Responses\Completions\CreateResponseUsage;
use PHPUnit\Framework\Assert;

uses(\Modules\AI\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\AI\Tests\TestCase $this */
    $this->action = new CompletionAction;
});

afterEach(function (): void {
Mockery::close();

});

describe('Completion Action', function (): void {
    test('_creates_completion_with_valid_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        $action = new \Modules\AI\Actions\CompletionAction;
        $prompt = 'Explain what PHP is';
        $expectedText = 'PHP is a server-side scripting language designed for web development.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows([
            'promptTokens' => 5,
            'completionTokens' => 20,
            'totalTokens' => 25,
        ]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows([
            'choices' => [$mockChoice],
            'usage' => $mockUsage,
        ]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->with([
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => $prompt,
                'temperature' => 0.5,
                'max_tokens' => 100,
                'top_p' => 1.0,
                'frequency_penalty' => 0.0,
                'presence_penalty' => 0.0,
            ])
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
        Assert::assertSame(5, $result->promptTokens);
        Assert::assertSame(20, $result->completionTokens);
        Assert::assertSame(25, $result->totalTokens);
    });

    test('_handles_empty_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = '';
        $expectedText = 'No prompt provided.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows([
            'promptTokens' => 0,
            'completionTokens' => 5,
            'totalTokens' => 5,
        ]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows([
            'choices' => [$mockChoice],
            'usage' => $mockUsage,
        ]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_long_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = str_repeat('This is a very long prompt that tests the handling of extended text content. ', 50);
        $expectedText = 'Response to long prompt.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows(['promptTokens' => 250]);
        $mockUsage->allows(['completionTokens' => 10]);
        $mockUsage->allows(['totalTokens' => 260]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows(['choices' => [$mockChoice]]);
        $mockResponse->allows(['usage' => $mockUsage]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
        Assert::assertSame(250, $result->promptTokens);
    });

    test('_handles_special_characters_in_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = 'What is the meaning of life? 42! @#$%^&*()';
        $expectedText = 'The meaning of life is a philosophical question.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows(['promptTokens' => 15]);
        $mockUsage->allows(['completionTokens' => 12]);
        $mockUsage->allows(['totalTokens' => 27]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows(['choices' => [$mockChoice]]);
        $mockResponse->allows(['usage' => $mockUsage]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_multilingual_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = '¿Qué es PHP? Explain in Spanish and English.';
        $expectedText = 'PHP es un lenguaje de programación. PHP is a programming language.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows(['promptTokens' => 12]);
        $mockUsage->allows(['completionTokens' => 18]);
        $mockUsage->allows(['totalTokens' => 30]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows(['choices' => [$mockChoice]]);
        $mockResponse->allows(['usage' => $mockUsage]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_code_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = 'Write a PHP function to calculate factorial: function factorial($n) {';
        $expectedText = 'return $n <= 1 ? 1 : $n * factorial($n - 1); }';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows(['promptTokens' => 20]);
        $mockUsage->allows(['completionTokens' => 25]);
        $mockUsage->allows(['totalTokens' => 45]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows(['choices' => [$mockChoice]]);
        $mockResponse->allows(['usage' => $mockUsage]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_technical_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = 'Explain the SOLID principles in software development.';
        $expectedText = 'SOLID principles are five design principles for object-oriented programming.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows(['promptTokens' => 10]);
        $mockUsage->allows(['completionTokens' => 15]);
        $mockUsage->allows(['totalTokens' => 25]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows(['choices' => [$mockChoice]]);
        $mockResponse->allows(['usage' => $mockUsage]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_question_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = 'What are the best practices for Laravel development?';
        $expectedText = 'Laravel best practices include using Eloquent ORM, following PSR standards, and implementing proper validation.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows(['promptTokens' => 12]);
        $mockUsage->allows(['completionTokens' => 22]);
        $mockUsage->allows(['totalTokens' => 34]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows(['choices' => [$mockChoice]]);
        $mockResponse->allows(['usage' => $mockUsage]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
    });

    test('_handles_creative_prompt', function (): void {
        /** @var \Modules\AI\Tests\TestCase $this */
        // action instantiated locally
        $prompt = 'Write a short story about a developer who discovers a magical bug.';
        $expectedText = 'Once upon a time, there was a developer named Alex who found a bug that glowed with an otherworldly light.';

        $mockChoice = Mockery::mock(CreateResponseChoice::class);
        $mockChoice->allows(['text' => $expectedText]);

        $mockUsage = Mockery::mock(CreateResponseUsage::class);
        $mockUsage->allows(['promptTokens' => 15]);
        $mockUsage->allows(['completionTokens' => 30]);
        $mockUsage->allows(['totalTokens' => 45]);

        $mockResponse = Mockery::mock(CreateResponse::class);
        $mockResponse->allows(['choices' => [$mockChoice]]);
        $mockResponse->allows(['usage' => $mockUsage]);

        OpenAI::shouldReceive('completions->create')
            ->once()
            ->andReturn($mockResponse);

        $result = $action->execute($prompt);

        Assert::assertInstanceOf(CompletionData::class, $result);
        Assert::assertSame($expectedText, $result->text);
    });
});
