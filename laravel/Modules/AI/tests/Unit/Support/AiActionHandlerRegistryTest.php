<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Support;

use Modules\AI\Contracts\AiActionHandlerContract;
use Modules\AI\Models\AiActionProposal;
use Modules\AI\Adapters\AiActionHandlerRegistry;
use PHPUnit\Framework\Assert;

test('registry registers and resolves handlers by type', function (): void {
    $registry = new AiActionHandlerRegistry;

    $handler = new class implements AiActionHandlerContract
    {
        public function type(): string
        {
            return 'noop';
        }

        public function handle(AiActionProposal $proposal): array
        {
            return ['ok' => true];
        }
    };

    Assert::assertFalse($registry->has('noop'));

    $registry->register($handler);

    Assert::assertTrue($registry->has('noop'));
    Assert::assertSame($handler, $registry->get('noop'));
    Assert::assertNull($registry->get('unknown'));
    Assert::assertSame(['noop' => $handler], $registry->all());
});
