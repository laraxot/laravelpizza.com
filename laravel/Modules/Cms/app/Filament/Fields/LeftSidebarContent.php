<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Fields;

use Filament\Forms\Components\Builder;

class LeftSidebarContent
{
    public static function make(string $name, string $_context = 'form'): Builder
    {
        return Builder::make($name)->blocks([])->collapsible();
    }
}
