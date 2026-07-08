<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Modules\Xot\Filament\Tables\Columns\XotBaseColumnGroup;

final class DummyActionsColumn extends XotBaseColumnGroup
{
    protected string $view = 'ui::filament.tables.columns.dummy-actions-column';
}
