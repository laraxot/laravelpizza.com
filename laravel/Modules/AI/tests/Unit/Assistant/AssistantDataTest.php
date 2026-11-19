<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Assistant;

use Modules\AI\Actions\AiJsonResponseDecoderAction;
use Modules\AI\Adapters\AiActionHandlerRegistry;
use Modules\AI\Adapters\AssistantHandoffHandler;
use Modules\AI\Datas\AssistantAnswerData;
use Modules\AI\Datas\AssistantReportData;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('AssistantAnswerData::fromModelResponse', function (): void {
    test('_accepts_a_grounded_answer_and_keeps_only_sources_actually_given', function (): void {
        $data = AssistantAnswerData::fromModelResponse(
            '{"answer":" Costa 5 euro. ","handoff":false,"reason":null,"source_ids":[2,99]}',
            [1, 2],
        );

        Assert::assertFalse($data->needsHuman);
        Assert::assertSame('Costa 5 euro.', $data->answer);
        Assert::assertSame([2], $data->sourceIds);
    });

    test('_accepts_json_wrapped_in_a_markdown_block', function (): void {
        $data = AssistantAnswerData::fromModelResponse("```json\n{\"answer\":\"Si\",\"handoff\":false}\n```", []);

        Assert::assertFalse($data->needsHuman);
        Assert::assertSame('Si', $data->answer);
    });

    test('_hands_off_when_the_model_asks_for_it', function (): void {
        $data = AssistantAnswerData::fromModelResponse('{"answer":"...","handoff":true,"reason":"angry_customer"}', [1]);

        Assert::assertTrue($data->needsHuman);
        Assert::assertSame('angry_customer', $data->handoffReason);
    });

    test('_hands_off_on_invalid_or_empty_responses', function (): void {
        foreach (['not json', '', '{"answer":"   "}', '{"handoff":false}'] as $raw) {
            $data = AssistantAnswerData::fromModelResponse($raw, [1]);

            Assert::assertTrue($data->needsHuman, 'raw='.$raw);
            Assert::assertSame('invalid_model_response', $data->handoffReason, 'raw='.$raw);
        }
    });
});

describe('AssistantReportData::fromAnswerPayloads', function (): void {
    test('_counts_answers_handoffs_sources_and_unanswered_questions', function (): void {
        $report = AssistantReportData::fromAnswerPayloads([
            ['needs_human' => false, 'source_ids' => [2]],
            ['needs_human' => false, 'source_ids' => [2, 3]],
            ['needs_human' => true, 'handoff_reason' => 'no_knowledge', 'question' => 'Avete parcheggio?'],
            ['needs_human' => true, 'handoff_reason' => 'no_knowledge', 'question' => 'Avete parcheggio?'],
            ['needs_human' => true, 'handoff_reason' => 'sensitive_topic:rimbors', 'question' => 'Rimborso?'],
        ]);

        Assert::assertSame(5, $report->questions);
        Assert::assertSame(2, $report->answered);
        Assert::assertSame(3, $report->handoffs);
        Assert::assertSame([2 => 2, 3 => 1], $report->topSourceIds);
        Assert::assertSame(['no_knowledge' => 2, 'sensitive_topic:rimbors' => 1], $report->handoffReasons);
        Assert::assertSame(['Avete parcheggio?'], $report->unansweredQuestions);
    });
});

describe('Assistant wiring', function (): void {
    test('_the_handoff_handler_is_registered_by_default', function (): void {
        Assert::assertInstanceOf(
            AssistantHandoffHandler::class,
            app(AiActionHandlerRegistry::class)->get(AssistantHandoffHandler::TYPE),
        );
    });

    test('_json_decoder_still_rejects_plain_text', function (): void {
        Assert::assertSame([], AiJsonResponseDecoderAction::decodeObject('```hello```'));
    });
});
