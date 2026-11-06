<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Models;

use Modules\AI\Enums\AiActionProposalStatusEnum;
use Modules\AI\Models\AiActionProposal;
use PHPUnit\Framework\Assert;

test('ai action proposal casts attributes', function (): void {
    $casts = (new AiActionProposal)->getCasts();

    Assert::assertSame('array', $casts['payload']);
    Assert::assertSame('array', $casts['result']);
    Assert::assertSame('datetime', $casts['confirmed_at']);
    Assert::assertSame('datetime', $casts['executed_at']);
    Assert::assertSame(AiActionProposalStatusEnum::class, $casts['status']);
});

test('ai action proposal status enum values are correct', function (): void {
    Assert::assertSame('pending', AiActionProposalStatusEnum::PENDING->value);
    Assert::assertSame('cancelled', AiActionProposalStatusEnum::CANCELLED->value);
    Assert::assertSame('confirmed', AiActionProposalStatusEnum::CONFIRMED->value);
    Assert::assertSame('executed', AiActionProposalStatusEnum::EXECUTED->value);
    Assert::assertSame('failed', AiActionProposalStatusEnum::FAILED->value);
});
