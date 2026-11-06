<?php

declare(strict_types=1);

namespace Modules\Cms\Providers\Filament;

use Filament\Auth\Pages\EditProfile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Cms\Filament\Pages\Themes;
use Modules\Xot\Datas\MetatagData;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class FrontPanelProvider extends XotBasePanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('cms::front')
            ->path('{lang}/front')
            ->colors(MetatagData::make()->getFilamentColors())
            ->discoverResources(
                in: app_path('Filament/Front/Resources'),
                for: 'App\\Filament\\Front\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Front/Pages'),
                for: 'App\\Filament\\Front\\Pages',
            )
            ->pages([
                //  Dashboard::class,
                // Login::class,
                Themes::class,
                EditProfile::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Front/Widgets'),
                for: 'App\\Filament\\Front\\Widgets',
            )
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
