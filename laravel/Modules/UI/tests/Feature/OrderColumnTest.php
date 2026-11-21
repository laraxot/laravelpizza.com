<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Filament\Tables\Columns\OrderColumn;
use PHPUnit\Framework\Assert;

describe('OrderColumn (Table) — order_column badge display', function (): void {
    it('can be instantiated with make() using the default name', function (): void {
        $column = OrderColumn::make();
        Assert::assertSame('order_column', $column->getName());
    });

    it('accepts a custom column name', function (): void {
        $column = OrderColumn::make('position');
        Assert::assertSame('position', $column->getName());
    });

    it('lets the label auto-resolve instead of hardcoding one', function (): void {
        // No ->label() call in make(): Filament/LangServiceProvider auto-resolve
        // from the field name until a translation exists (see AutoLabelAction).
        $column = OrderColumn::make();
        Assert::assertSame('Order column', $column->getLabel());
    });

    it('is sortable', function (): void {
        $column = OrderColumn::make();
        Assert::assertTrue($column->isSortable());
    });

    it('is hidden by default but toggleable', function (): void {
        $column = OrderColumn::make();
        Assert::assertTrue($column->isToggleable());
        Assert::assertTrue($column->isToggledHiddenByDefault());
    });

    it('renders as a badge, distinct from plain text columns', function (): void {
        $column = OrderColumn::make();
        Assert::assertTrue($column->isBadge());
    });
});
