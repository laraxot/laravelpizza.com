<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Pages\Dashboard as FilamentDashboard;

abstract class XotBaseDashboard extends FilamentDashboard
{
    public function getWidgets(): array
    {
        return [
            // Override if needed
        ];
    }

    public function getColumns(): int|array
    {
        return 2;
    }
}
