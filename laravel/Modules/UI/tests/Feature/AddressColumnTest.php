<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\AddressColumn;
use PHPUnit\Framework\Assert;

describe('AddressColumn — controparte di AddressField', function (): void {
    it('can be instantiated with make() using the default name', function (): void {
        $column = AddressColumn::make();
        Assert::assertSame('address', $column->getName());
    });

    it('accepts a custom relationship name', function (): void {
        $column = AddressColumn::make('billing_address');
        Assert::assertSame('billing_address', $column->getName());
    });

    it('exposes the default field set, one TextColumn per field', function (): void {
        $column = AddressColumn::make();
        $fields = $column->getFields();

        Assert::assertCount(5, $fields);
        foreach ($fields as $field) {
            Assert::assertInstanceOf(TextColumn::class, $field);
        }
    });

    it('names each child column with the relationship dot-path', function (): void {
        $column = AddressColumn::make('address');
        $names = array_map(static fn (Column $field): string => $field->getName(), $column->getFields());

        Assert::assertSame([
            'address.country',
            'address.street',
            'address.city',
            'address.state',
            'address.zip',
        ], $names);
    });

    it('restricts the field set via fields()', function (): void {
        $column = AddressColumn::make()->fields(['city', 'zip']);
        $names = array_map(static fn (Column $field): string => $field->getName(), $column->getFields());

        Assert::assertSame(['address.city', 'address.zip'], $names);
    });
});
