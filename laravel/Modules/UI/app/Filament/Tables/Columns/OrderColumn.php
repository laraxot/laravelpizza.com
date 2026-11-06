<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Modules\Xot\Filament\Tables\Columns\XotBaseTextColumn;

/**
 * Displays an order/position value as a badge, distinct from regular data columns.
 *
 * Hidden by default (toggleable): order_column is reordering metadata, not
 * primary business data — drag-and-drop remains the primary reorder UX, this
 * column just lets power users inspect the numeric position on demand.
 */
class OrderColumn extends XotBaseTextColumn
{
    #[\Override]
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'order_column')
            ->badge()
            ->color('gray')
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true)
            ->tooltip('Position in list — drag to reorder')
            ->alignment('center');
    }
}
