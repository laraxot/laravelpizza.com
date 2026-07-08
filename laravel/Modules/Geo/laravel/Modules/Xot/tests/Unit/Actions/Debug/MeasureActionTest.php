<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Debug\MeasureAction;
use PHPUnit\Framework\Assert;

it('measures performance', function (): void {
    $action = app(MeasureAction::class);
    $result = $action->execute(function () {
        return 'done';
    }, 'Test Measurement');

    Assert::assertSame('done', $result);
});
