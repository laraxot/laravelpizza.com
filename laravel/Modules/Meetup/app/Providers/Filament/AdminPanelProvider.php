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
            'meetup-icon-calendar' => 'meetup-icon-calendar',
            'meetup-icon-chat' => 'meetup-icon-chat',
            'meetup-icon-check' => 'meetup-icon-check',
            'meetup-icon-chevron-down' => 'meetup-icon-chevron-down',
            'meetup-icon-community' => 'meetup-icon-community',
            'meetup-icon-language' => 'meetup-icon-language',
            'meetup-icon-menu' => 'meetup-icon-menu',
            'meetup-icon-sponsors' => 'meetup-icon-sponsors',
            'meetup-facebook' => 'meetup-facebook',
            'meetup-github' => 'meetup-github',
            'meetup-twitter' => 'meetup-twitter',
        ]);

        return $panel;
    }
}
