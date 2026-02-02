<?php

declare(strict_types=1);

namespace Modules\Meetup\Providers\Filament;

use Filament\Panel;
use Filament\Support\Facades\FilamentIcon;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Override;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Meetup';

    #[Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        FilamentIcon::register([
            'meetup-logo' => 'meetup-logo',
        ]);

        return $panel;
    }
}
