<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Tables\Columns;

use Modules\Xot\Filament\Tables\Columns\XotBaseIconColumn;

class IconColumn extends XotBaseIconColumn
{
    protected string $view = 'ui::filament.tables.columns.icon';
}
