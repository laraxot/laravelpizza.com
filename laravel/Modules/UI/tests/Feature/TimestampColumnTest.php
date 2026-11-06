<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Filament\Tables\Columns\TimestampColumn;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('TimestampColumn — colonna data/ora standard del progetto', function (): void {
    it('requires an explicit name (no universal default)', function (): void {
        $column = TimestampColumn::make('created_at');
        Assert::assertSame('created_at', $column->getName());
    });

    it('is sortable, formats as dateTime and placeholders nulls with —', function (): void {
        $column = TimestampColumn::make('created_at');
        Assert::assertTrue($column->isSortable());
        Assert::assertTrue($column->isDateTime());
        Assert::assertSame('—', $column->getPlaceholder());
    });

    it('stays composable: toggleable() can still be chained by the caller', function (): void {
        $column = TimestampColumn::make('updated_at')->toggleable(isToggledHiddenByDefault: true);
        Assert::assertTrue($column->isToggledHiddenByDefault());
    });
});
