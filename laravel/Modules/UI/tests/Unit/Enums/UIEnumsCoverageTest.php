<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Enums;

uses(\Modules\UI\Tests\TestCase::class);

use Modules\UI\Enums\CornerPositionEnum;
use Modules\UI\Enums\FieldTypeEnum;
use Modules\UI\Enums\TableLayout;

// --- CornerPositionEnum ---

it('CornerPositionEnum has correct values', function (): void {
    expect(CornerPositionEnum::TOP_LEFT->value)->toBe('top-left');
    expect(CornerPositionEnum::TOP_RIGHT->value)->toBe('top-right');
    expect(CornerPositionEnum::BOTTOM_LEFT->value)->toBe('bottom-left');
    expect(CornerPositionEnum::BOTTOM_RIGHT->value)->toBe('bottom-right');
});

it('CornerPositionEnum getColor returns gray for all cases', function (): void {
    foreach (CornerPositionEnum::cases() as $case) {
        expect($case->getColor())->toBe('gray');
    }
});

it('CornerPositionEnum getIcon returns heroicon strings', function (): void {
    expect(CornerPositionEnum::TOP_LEFT->getIcon())->toBe('heroicon-o-arrow-up-left');
    expect(CornerPositionEnum::TOP_RIGHT->getIcon())->toBe('heroicon-o-arrow-up-right');
    expect(CornerPositionEnum::BOTTOM_LEFT->getIcon())->toBe('heroicon-o-arrow-down-left');
    expect(CornerPositionEnum::BOTTOM_RIGHT->getIcon())->toBe('heroicon-o-arrow-down-right');
});

it('CornerPositionEnum getCssClass returns correct CSS classes', function (): void {
    expect(CornerPositionEnum::TOP_LEFT->getCssClass())->toBe('top-0 left-0');
    expect(CornerPositionEnum::TOP_RIGHT->getCssClass())->toBe('top-0 right-0');
    expect(CornerPositionEnum::BOTTOM_LEFT->getCssClass())->toBe('bottom-0 left-0');
    expect(CornerPositionEnum::BOTTOM_RIGHT->getCssClass())->toBe('bottom-0 right-0');
});

it('CornerPositionEnum can be created from value', function (): void {
    expect(CornerPositionEnum::from('top-left'))->toBe(CornerPositionEnum::TOP_LEFT);
    expect(CornerPositionEnum::from('bottom-right'))->toBe(CornerPositionEnum::BOTTOM_RIGHT);
});

it('CornerPositionEnum getLabel returns a string', function (): void {
    foreach (CornerPositionEnum::cases() as $case) {
        expect($case->getLabel())->toBeString();
    }
});

// --- FieldTypeEnum ---

it('FieldTypeEnum has correct values', function (): void {
    expect(FieldTypeEnum::TEXT->value)->toBe('text');
    expect(FieldTypeEnum::EMAIL->value)->toBe('email');
    expect(FieldTypeEnum::TEXTAREA->value)->toBe('textarea');
    expect(FieldTypeEnum::SELECT->value)->toBe('select');
    expect(FieldTypeEnum::RADIO->value)->toBe('radio');
    expect(FieldTypeEnum::CHECKBOX->value)->toBe('checkbox');
    expect(FieldTypeEnum::DATE->value)->toBe('date');
    expect(FieldTypeEnum::TIME->value)->toBe('time');
    expect(FieldTypeEnum::DATETIME->value)->toBe('datetime');
});

it('FieldTypeEnum implements HasLabel, HasColor, HasIcon', function (): void {
    expect(FieldTypeEnum::TEXT)->toBeInstanceOf(Filament\Support\Contracts\HasLabel::class);
    expect(FieldTypeEnum::TEXT)->toBeInstanceOf(Filament\Support\Contracts\HasColor::class);
    expect(FieldTypeEnum::TEXT)->toBeInstanceOf(Filament\Support\Contracts\HasIcon::class);
});

it('FieldTypeEnum getLabel returns a string', function (): void {
    foreach (FieldTypeEnum::cases() as $case) {
        expect($case->getLabel())->toBeString();
    }
});

it('FieldTypeEnum getColor returns a string', function (): void {
    foreach (FieldTypeEnum::cases() as $case) {
        expect($case->getColor())->toBeString();
    }
});

it('FieldTypeEnum getIcon returns a string', function (): void {
    foreach (FieldTypeEnum::cases() as $case) {
        expect($case->getIcon())->toBeString();
    }
});

it('FieldTypeEnum getDescription returns a string', function (): void {
    foreach (FieldTypeEnum::cases() as $case) {
        expect($case->getDescription())->toBeString();
    }
});

it('FieldTypeEnum can be created from value', function (): void {
    expect(FieldTypeEnum::from('text'))->toBe(FieldTypeEnum::TEXT);
    expect(FieldTypeEnum::from('email'))->toBe(FieldTypeEnum::EMAIL);
});

// --- TableLayout ---

it('TableLayout has correct values', function (): void {
    expect(TableLayout::LIST->value)->toBe('list');
    expect(TableLayout::GRID->value)->toBe('grid');
});

it('TableLayout getLabel returns correct labels', function (): void {
    expect(TableLayout::LIST->getLabel())->toBe('List View');
    expect(TableLayout::GRID->getLabel())->toBe('Grid View');
});

it('TableLayout getColor returns correct colors', function (): void {
    expect(TableLayout::LIST->getColor())->toBe('primary');
    expect(TableLayout::GRID->getColor())->toBe('secondary');
});

it('TableLayout getIcon returns correct icons', function (): void {
    expect(TableLayout::LIST->getIcon())->toBe('heroicon-o-list-bullet');
    expect(TableLayout::GRID->getIcon())->toBe('heroicon-o-squares-2x2');
});

it('TableLayout toggle switches between layouts', function (): void {
    expect(TableLayout::LIST->toggle())->toBe(TableLayout::GRID);
    expect(TableLayout::GRID->toggle())->toBe(TableLayout::LIST);
});

it('TableLayout can be created from value', function (): void {
    expect(TableLayout::from('list'))->toBe(TableLayout::LIST);
    expect(TableLayout::from('grid'))->toBe(TableLayout::GRID);
});
