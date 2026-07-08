<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Services;

use Modules\AI\Actions\CompletionAction;
use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
    $this->action = new CompletionAction;
});

describe('CompletionAction', function (): void {
    test('_action_can_be_instantiated', function (): void {
        /** @var TestCase $this */
        Assert::assertInstanceOf(CompletionAction::class, $this->action);
    });
});
