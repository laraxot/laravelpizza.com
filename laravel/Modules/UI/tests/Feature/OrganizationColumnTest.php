<?php

declare(strict_types=1);

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\OrganizationColumn;
use Modules\UI\Tests\TestCase;

uses(TestCase::class);
it('provides the schema.org organization field set', function (): void {
    $column = OrganizationColumn::make();

    expect($column->getName())->toBe('organization')
        ->and($column->getFields())->toHaveCount(6)
        ->each->toBeInstanceOf(TextColumn::class);
});

it('allows a smaller organization projection', function (): void {
    $fields = OrganizationColumn::make()->fields(['name', 'url'])->getFields();

    expect($fields)->toHaveCount(2)
        ->and(array_map(static fn (Column $column): string => $column->getName(), $fields))
        ->toBe(['name', 'url']);
});
