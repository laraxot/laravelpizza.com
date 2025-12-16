<?php

declare(strict_types=1);

namespace Modules\Activity\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Override;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Activity';

    #[Override]
    public function panel(Panel $panel): Panel
    {
        return parent::panel($panel);
    }
}
