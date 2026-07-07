<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Modules\UI\Filament\Forms\Components\EnumSelect;
use PHPUnit\Framework\Assert;

uses(\Modules\UI\Tests\TestCase::class);

it('generates options from enum class', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

    Assert::assertCount(3, $options);
    foreach (['red', 'green', 'blue'] as $key) {
        Assert::assertArrayHasKey($key, $options);
    }
});

it('uses HasLabel interface when available', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

    Assert::assertNotEmpty($options['red']);
    Assert::assertNotEmpty($options['green']);
});

it('falls back to case name when HasLabel not implemented', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestNoLabelEnum::class);

    $options = $select->getOptions();

    Assert::assertSame('ALPHA', $options['alpha']);
    Assert::assertSame('BETA', $options['beta']);
});

it('rejects plain (non-backed) enums when resolving options', function (): void {
    $select = EnumSelect::make('enum')->enum(TestPureUnitEnum::class);

    try {
        $select->getOptions();
        Assert::fail('Expected InvalidArgumentException');
    } catch (\InvalidArgumentException $e) {
        Assert::assertStringContainsString('must be a backed enum', $e->getMessage());
    }
});

it('rejects classes that are not enums when resolving options', function (): void {
    $select = EnumSelect::make('enum')->enum(\stdClass::class);

    try {
        $select->getOptions();
        Assert::fail('Expected InvalidArgumentException');
    } catch (\InvalidArgumentException $e) {
        Assert::assertStringContainsString('does not exist', $e->getMessage());
    }
});

it('converts value to enum case', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    $result = $select->convertToEnum('red');
    Assert::assertSame(TestColorEnum::RED, $result);
    $result = $select->convertToEnum('invalid');
    Assert::assertNull($result);
    $result = $select->convertToEnum(null);
    Assert::assertNull($result);
});

it('enables icons when requested', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);
    $select->icons();

    Assert::assertTrue($select->hasIcons());
});

it('enables html labels when requested', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);
    $select->htmlLabels();

    Assert::assertTrue($select->allowsHtml());
});

it('returns correct enum class', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);

    Assert::assertSame(TestColorEnum::class, $select->getEnumClass());
});

it('formats html labels with icons', function (): void {
    $select = EnumSelect::make('enum');
    $select->enum(TestColorEnum::class);
    $select->icons();
    $select->htmlLabels();

    $options = $select->getOptions();

    $redOption = $options['red'];
    Assert::assertIsString($redOption);
    Assert::assertStringContainsString('heroicon-o-exclamation', $redOption);
    Assert::assertStringContainsString('Rosso', $redOption);
});
