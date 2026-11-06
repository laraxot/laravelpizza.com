<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBaseViewField;

/**
 * Displays the order/position value as a badge with up/down arrows to move
 * the record one position at a time — the form-edit counterpart of the
 * Tables\Columns\OrderColumn badge used in listings.
 */
class OrderColumn extends XotBaseViewField
{
    protected string $view = 'ui::filament.forms.components.order-column';

    #[\Override]
    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'order_column')
            ->default(0);
    }
}
