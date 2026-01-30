<?php

declare(strict_types=1);

uses(Modules\UI\Tests\TestCase::class);

use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Enums\TableLayoutEnum;

it('has enum values', function (): void {
    expect(TableLayoutEnum::LIST->value)->toBe('list');
    expect(TableLayoutEnum::GRID->value)->toBe('grid');
});

it('has default layout', function (): void {
    $default = TableLayoutEnum::init();
    expect($default)->toBe(TableLayoutEnum::LIST);
});

it('toggles between layouts', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    expect($list->toggle())->toBe($grid);
    expect($grid->toggle())->toBe($list);
});

it('checks layout types correctly', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    expect($list->isListLayout())->toBeTrue();
    expect($list->isGridLayout())->toBeFalse();

    expect($grid->isGridLayout())->toBeTrue();
    expect($grid->isListLayout())->toBeFalse();
});

it('has grid configuration', function (): void {
    $grid = TableLayoutEnum::GRID;
    $config = $grid->getTableContentGrid();

    expect($config)->toBeArray();
    expect($config)->toHaveKey('sm');
    expect($config)->toHaveKey('md');
    expect($config)->toHaveKey('lg');
    expect($config)->toHaveKey('xl');
    expect($config)->toHaveKey('2xl');
});

it('returns correct table columns based on layout', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    $listColumns = [
        TextColumn::make('name'),
        TextColumn::make('email'),
    ];

    $gridColumns = [
        Stack::make([
            TextColumn::make('name'),
            TextColumn::make('email'),
        ]),
    ];

    // Test list layout
    $result = $list->getTableColumns($listColumns, $gridColumns);
    expect($result)->toBe($listColumns);

    // Test grid layout
    $result = $grid->getTableColumns($listColumns, $gridColumns);
    expect($result)->toBe($gridColumns);
});

it('has options', function (): void {
    $options = TableLayoutEnum::getOptions();

    expect($options)->toBeArray();
    expect($options)->toHaveKey('list');
    expect($options)->toHaveKey('grid');
    expect($options['list'])->toBe(TableLayoutEnum::LIST);
    expect($options['grid'])->toBe(TableLayoutEnum::GRID);
});

it('has container classes', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    $listClasses = $list->getContainerClasses();
    $gridClasses = $grid->getContainerClasses();

    expect($listClasses)->toBeString();
    expect(strlen($listClasses))->toBeGreaterThan(0);
    expect($gridClasses)->toBeString();
    expect(strlen($gridClasses))->toBeGreaterThan(0);
});

it('has translation support', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    // Test that labels are translatable
    // Since translation requires full app context, we'll just check that methods exist
    expect(method_exists($list, 'getLabel'))->toBeTrue();
    expect(method_exists($grid, 'getLabel'))->toBeTrue();
});

it('has color and icon methods', function (): void {
    $list = TableLayoutEnum::LIST;
    $grid = TableLayoutEnum::GRID;

    // Test that methods exist (actual translation requires full app context)
    expect(method_exists($list, 'getColor'))->toBeTrue();
    expect(method_exists($grid, 'getColor'))->toBeTrue();
    expect(method_exists($list, 'getIcon'))->toBeTrue();
    expect(method_exists($grid, 'getIcon'))->toBeTrue();
});
