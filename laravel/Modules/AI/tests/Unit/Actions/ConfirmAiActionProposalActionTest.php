<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Modules\AI\Actions\ConfirmAiActionProposalAction;
use Modules\AI\Adapters\AiActionHandlerRegistry;
use Modules\AI\Contracts\AiActionHandlerContract;
use Modules\AI\Enums\AiActionProposalStatusEnum;
use Modules\AI\Models\AiActionProposal;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Contratto: docs/contracts/confirm-ai-action-proposal-action.md. Il salvataggio e' bloccato dall'evento `saving`: qui si prova
 * la macchina a stati della proposta, non lo schema di `ai_action_proposals`.
 */

beforeEach(function (): void {
    AiActionProposal::saving(static fn (): bool => false);
});

function confirmableProposal(string $type): AiActionProposal
{
    $proposal = new AiActionProposal;
    $proposal->forceFill(['type' => $type, 'payload' => ['x' => 1], 'status' => AiActionProposalStatusEnum::PENDING]);

    return $proposal;
}

function confirmHandler(string $type, ?\Throwable $failure = null): AiActionHandlerContract
{
    return new class($type, $failure) implements AiActionHandlerContract
    {
        public function __construct(private readonly string $type, private readonly ?\Throwable $failure) {}

        public function type(): string
        {
            return $this->type;
        }

        public function handle(AiActionProposal $proposal): array
        {
            if ($this->failure !== null) {
                throw $this->failure;
            }

            return ['done' => true];
        }
    };
}

test('_confirms_with_the_uuid_of_the_user_and_executes_the_registered_handler', function (): void {
    $registry = (new AiActionHandlerRegistry)->register(confirmHandler('noop'));
    $uuid = '0b6f1c1e-6a2b-4c1d-9f3e-2a7d5c8b9e10';

    $proposal = (new ConfirmAiActionProposalAction($registry))->execute(confirmableProposal('noop'), $uuid);

    Assert::assertSame(AiActionProposalStatusEnum::EXECUTED, $proposal->status);
    Assert::assertSame($uuid, $proposal->getAttribute('confirmed_by_user_id'));
    Assert::assertNotNull($proposal->getAttribute('confirmed_at'));
    Assert::assertNotNull($proposal->getAttribute('executed_at'));
    Assert::assertSame(['done' => true], $proposal->getAttribute('result'));
})->group('AI-CONFIRM-INV-1', 'AI-CONFIRM-INV-2');

test('_marks_the_proposal_failed_when_no_handler_is_registered_for_its_type', function (): void {
    $proposal = (new ConfirmAiActionProposalAction(new AiActionHandlerRegistry))->execute(confirmableProposal('unknown'), 'user-1');

    Assert::assertSame(AiActionProposalStatusEnum::FAILED, $proposal->status);
    $error = $proposal->getAttribute('error');
    Assert::assertIsString($error);
    Assert::assertStringContainsString('[unknown]', $error);
    Assert::assertNull($proposal->getAttribute('executed_at'));
})->group('AI-CONFIRM-INV-3');

test('_stores_the_handler_error_instead_of_throwing_it', function (): void {
    $registry = (new AiActionHandlerRegistry)->register(confirmHandler('boom', new \RuntimeException('dominio non disponibile')));

    $proposal = (new ConfirmAiActionProposalAction($registry))->execute(confirmableProposal('boom'), 'user-1');

    Assert::assertSame(AiActionProposalStatusEnum::FAILED, $proposal->status);
    Assert::assertSame('dominio non disponibile', $proposal->getAttribute('error'));
})->group('AI-CONFIRM-INV-3', 'AI-CONFIRM-INV-4');
