<?php

declare(strict_types=1);

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\EventColumn;
use Modules\UI\Tests\TestCase;

uses(TestCase::class);
it('provides the schema.org event field set', function (): void {
    $column = EventColumn::make();

    expect($column->getName())->toBe('event')
        ->and($column->getFields())->toHaveCount(11)
        ->each->toBeInstanceOf(TextColumn::class);
});

it('allows a smaller event projection', function (): void {
    $fields = EventColumn::make()->fields(['name', 'start_date'])->getFields();

    expect($fields)->toHaveCount(2)
        ->and(array_map(static fn (Column $column): string => $column->getName(), $fields))
        ->toBe(['name', 'start_date']);
});
