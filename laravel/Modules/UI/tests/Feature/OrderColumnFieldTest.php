<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Filament\Forms\Components\OrderColumn;
use PHPUnit\Framework\Assert;

describe('OrderColumn (Form) — order_column badge with move up/down arrows', function (): void {
    it('can be instantiated with make() using the default name', function (): void {
        $field = OrderColumn::make();
        Assert::assertSame('order_column', $field->getName());
    });

    it('accepts a custom field name', function (): void {
        $field = OrderColumn::make('position');
        Assert::assertSame('position', $field->getName());
    });

    it('lets the label auto-resolve instead of hardcoding one', function (): void {
        // No ->label() call in make(): Filament/LangServiceProvider auto-resolve
        // from the field name until a translation exists (see AutoLabelAction).
        $field = OrderColumn::make();
        Assert::assertSame('Order column', $field->getLabel());
    });

    it('defaults to zero', function (): void {
        $field = OrderColumn::make();
        Assert::assertSame(0, $field->getDefaultState());
    });

    it('resolves a dedicated view distinct from plain view fields', function (): void {
        $field = OrderColumn::make();
        Assert::assertSame('ui::filament.forms.components.order-column', $field->getView());
    });
});
