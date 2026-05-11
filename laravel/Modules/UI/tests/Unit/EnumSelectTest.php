<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

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
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

    expect($options)->toBeArray()
        ->toHaveCount(3)
        ->toHaveKeys(['red', 'green', 'blue']);
});

it('uses HasLabel interface when available', function () {
    $select = new EnumSelect();
    $select->enum(TestColorEnum::class);

    $options = $select->getOptions();

    expect($options['red'])->toContain('Rosso');
    expect($options['green'])->toContain('Verde');
});

it('falls back to case name when HasLabel not implemented', function () {
    $select = new EnumSelect();
    $select->enum(TestNoLabelEnum::class);

    $options = $select->getOptions();

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
    $select->enum(TestColorEnum::class);
    $select->icons();
    $select->htmlLabels();

    $options = $select->getOptions();

    expect($options['red'])->toContain('heroicon-o-exclamation');
    expect($options['red'])->toContain('Rosso');
});
