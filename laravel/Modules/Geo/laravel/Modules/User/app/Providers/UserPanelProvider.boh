<?php

namespace Modules\User\Providers;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Modules\User\Filament\Widgets\RegistrationWidget;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('user')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->widgets([
                RegistrationWidget::class,
            ]);
    }
}
