<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Filament\Tables\Columns\SortableIdColumn;
use PHPUnit\Framework\Assert;

describe('SortableIdColumn — colonna id standard del progetto', function (): void {
    it('can be instantiated with make() using the default name', function (): void {
        $column = SortableIdColumn::make();
        Assert::assertSame('id', $column->getName());
    });

    it('accepts a custom name', function (): void {
        $column = SortableIdColumn::make('uuid');
        Assert::assertSame('uuid', $column->getName());
    });

    it('is sortable, copyable and toggleable hidden by default', function (): void {
        $column = SortableIdColumn::make();
        Assert::assertTrue($column->isSortable());
        Assert::assertTrue($column->isCopyable(1));
        Assert::assertTrue($column->isToggledHiddenByDefault());
    });
});
