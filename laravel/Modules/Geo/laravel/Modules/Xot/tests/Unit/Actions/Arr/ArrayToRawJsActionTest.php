<?php

declare(strict_types=1);

use Filament\Support\RawJs;
use Modules\Xot\Actions\Arr\ArrayToRawJsAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('converts mixed PHP arrays to RawJs correctly', function (): void {
    $action = app(ArrayToRawJsAction::class);

    $raw = $action->execute([
        'validKey' => true,
        'string key' => "O'Reilly",
        'number' => 12.5,
        'none' => null,
        'nested' => [
            'inner' => 1,
            'formatter' => RawJs::make('value => value * 2'),
        ],
    ]);

    Assert::assertInstanceOf(RawJs::class, $raw);
    $js = $raw->toHtml();
    Assert::assertStringContainsString('validKey: true', $js);
    Assert::assertStringContainsString("'string key': 'O\\'Reilly'", $js);
    Assert::assertStringContainsString('number: 12.5', $js);
    Assert::assertStringContainsString('none: null', $js);
    Assert::assertStringContainsString('formatter: value => value * 2', $js);
});
