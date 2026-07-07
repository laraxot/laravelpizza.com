<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

<<<<<<< HEAD
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Modules\UI\Filament\Forms\Components\EnumSelect;
use PHPUnit\Framework\TestCase;

// Test enums
enum TestColorEnum: string implements HasIcon, HasLabel
{
    case RED = 'red';
    case GREEN = 'green';
    case BLUE = 'blue';

    public function getLabel(): string
    {
        return match ($this) {
            self::RED => 'Rosso',
            self::GREEN => 'Verde',
            self::BLUE => 'Blu',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::RED => 'heroicon-o-exclamation',
            self::GREEN => 'heroicon-o-check',
            self::BLUE => 'heroicon-o-info',
        };
    }
}

enum TestSimpleEnum: string
{
    case ONE = 'one';
    case TWO = 'two';
    case THREE = 'three';
}

enum TestNoLabelEnum: string
{
    case ALPHA = 'alpha';
    case BETA = 'beta';
}

/*
 * @uses TestCase
 */
it('generates options from enum class', function () {
    $select = new EnumSelect();
=======
use Modules\UI\Filament\Forms\Components\EnumSelect;
use PHPUnit\Framework\Assert;

uses(\Modules\UI\Tests\TestCase::class);

it('generates options from enum class', function (): void {
    $select = EnumSelect::make('enum');
>>>>>>> 40b96bcd6 (.)
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

<<<<<<< HEAD
    expect($options)->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['red', 'green', 'blue']);
});

it('uses HasLabel interface when available', function () {
    $select = new EnumSelect();
=======
    Assert::assertCount(3, $options);
    foreach (['red', 'green', 'blue'] as $key) {
        Assert::assertArrayHasKey($key, $options);
    }
});

it('uses HasLabel interface when available', function (): void {
    $select = EnumSelect::make('enum');
>>>>>>> 40b96bcd6 (.)
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

<<<<<<< HEAD
    expect($options['red'])->toContain('Rosso');
    expect($options['green'])->toContain('Verde');
});

it('falls back to case name when HasLabel not implemented', function () {
    $select = new EnumSelect();
=======
    Assert::assertNotEmpty($options['red']);
    Assert::assertNotEmpty($options['green']);
});

it('falls back to case name when HasLabel not implemented', function (): void {
    $select = EnumSelect::make('enum');
>>>>>>> 40b96bcd6 (.)
    $select->enum(TestNoLabelEnum::class);

    $options = $select->getOptions();

<<<<<<< HEAD
    expect($options['alpha'])->toBe('ALPHA');
    expect($options['beta'])->toBe('BETA');
});

it('throws exception for non-backed enum', function () {
    $select = new EnumSelect();

    expect(fn () => $select->enum('stdClass'))
        ->toThrow(\Exception::class, 'does not exist');
});

it('throws exception for non-enum class', function () {
    $select = new EnumSelect();

    expect(fn () => $select->enum('App\Models\User'))
        ->toThrow(\Exception::class);
});

it('converts value to enum case', function () {
    $select = new EnumSelect();
    $select->enum(TestColorEnum::class);

    $result = $select->convertToEnum('red');
    expect($result)->toBe(TestColorEnum::RED);

    $result = $select->convertToEnum('invalid');
    expect($result)->toBeNull();

    $result = $select->convertToEnum(null);
    expect($result)->toBeNull();
});

it('enables icons when requested', function () {
    $select = new EnumSelect();
    $select->enum(TestColorEnum::class);
    $select->icons();

    expect($select->hasIcons())->toBeTrue();
});

it('enables html labels when requested', function () {
    $select = new EnumSelect();
    $select->enum(TestColorEnum::class);
    $select->htmlLabels();

    expect($select->allowsHtml())->toBeTrue();
});

it('returns correct enum class', function () {
    $select = new EnumSelect();
    $select->enum(TestColorEnum::class);

    expect($select->getEnumClass())->toBe(TestColorEnum::class);
});

it('formats html labels with icons', function () {
    $select = new EnumSelect();
=======
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
>>>>>>> 40b96bcd6 (.)
    $select->enum(TestColorEnum::class);
    $select->icons();
    $select->htmlLabels();

    $options = $select->getOptions();

<<<<<<< HEAD
    expect($options['red'])->toContain('heroicon-o-exclamation');
    expect($options['red'])->toContain('Rosso');
=======
    $redOption = $options['red'];
    Assert::assertIsString($redOption);
    Assert::assertStringContainsString('heroicon-o-exclamation', $redOption);
    Assert::assertStringContainsString('Rosso', $redOption);
>>>>>>> 40b96bcd6 (.)
});
