<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
    protected string $view = 'rating::filament.pages.dashboard';
}
