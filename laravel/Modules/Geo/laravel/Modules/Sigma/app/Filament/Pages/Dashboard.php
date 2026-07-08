<?php

declare(strict_types=1);

namespace Modules\Sigma\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-home';

    #[\Override]
    public function getSubheading(): string|Htmlable|null
    {
        return 'Here you will see an overview of your tasks.';
    }

    #[\Override]
    public function getWidgets(): array
    {
        return [
            // ...
        ];
    }
}
