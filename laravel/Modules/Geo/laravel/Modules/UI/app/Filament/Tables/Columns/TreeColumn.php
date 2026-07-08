<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Modules\Xot\Filament\Tables\Columns\XotBaseColumn;

final class TreeColumn extends XotBaseColumn
{
    protected string $view = 'ui::filament.tables.columns.tree-column';
}
