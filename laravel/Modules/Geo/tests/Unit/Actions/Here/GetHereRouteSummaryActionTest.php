<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Here;

use Modules\Geo\Actions\Here\GetHereRouteSummaryAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('can be resolved from container', function (): void {
    $action = app(GetHereRouteSummaryAction::class);

    Assert::assertInstanceOf(GetHereRouteSummaryAction::class, $action);
});

it('exposes execute method', function (): void {
    Assert::assertTrue((new \ReflectionClass(GetHereRouteSummaryAction::class))->hasMethod('execute'));
});
