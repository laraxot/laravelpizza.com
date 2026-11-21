<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\PersonColumn;
use PHPUnit\Framework\Assert;

describe('PersonColumn — controparte di PersonSection', function (): void {
    it('can be instantiated with make() using the default name', function (): void {
        $column = PersonColumn::make();
        Assert::assertSame('person', $column->getName());
    });

    it('accepts a custom name', function (): void {
        $column = PersonColumn::make('contact');
        Assert::assertSame('contact', $column->getName());
    });

    it('exposes the default field set, one TextColumn per field, directly on the record', function (): void {
        $column = PersonColumn::make();
        $names = array_map(static fn (Column $field): string => $field->getName(), $column->getFields());

        Assert::assertSame([
            'first_name',
            'last_name',
            'email',
            'mobile_phone',
            'language',
        ], $names);
        foreach ($column->getFields() as $field) {
            Assert::assertInstanceOf(TextColumn::class, $field);
        }
    });

    it('restricts the field set via fields()', function (): void {
        $column = PersonColumn::make()->fields(['first_name', 'last_name']);
        $names = array_map(static fn (Column $field): string => $field->getName(), $column->getFields());

        Assert::assertSame(['first_name', 'last_name'], $names);
    });
});
