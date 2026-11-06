<?php

declare(strict_types=1);

namespace Modules\Xot\Providers\Filament;

use Filament\Actions\Action;
use Filament\Auth\Pages\Login;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\User\Filament\Pages\MyProfilePage;
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;
use Modules\Xot\Actions\Filament\GetSidebarStateScriptAction;
use Modules\Xot\Actions\Panel\ApplyMetatagToPanelAction;
use Modules\Xot\Filament\AvatarProviders\InitialsAvatarProvider;
use Modules\Xot\Filament\Pages\MainDashboard;

abstract class XotBaseMainPanelProvider extends PanelProvider
{
    protected bool $topNavigation = false;

    public function panel(Panel $panel): Panel
    {
        $panel->id('admin')
            ->path('admin');

        $modules = app('modules');
        $hasCms = is_object($modules) && method_exists($modules, 'has')
            ? (bool) $modules->has('Cms')
            : false;

        if (! $hasCms) {
            // $panel->login(Login::class);
            $panel->login();
        }

        $panel = $panel
            ->passwordReset()
            // avatar predefinito generato in locale: il provider di Filament carica ui-avatars.com a ogni pagina (DCP-139)
            ->defaultAvatarProvider(InitialsAvatarProvider::class)
            ->sidebarFullyCollapsibleOnDesktop()
            ->spa()
            ->profile(null, true);

        $panel = app(ApplyMetatagToPanelAction::class)->execute(panel: $panel);

        // Discovery sicura: verifica che le directory esistano
        $resourcesPath = app_path('Filament/Resources');
        $pagesPath = app_path('Filament/Pages');
        $widgetsPath = app_path('Filament/Widgets');

        if (is_dir($resourcesPath)) {
            $panel = $panel->discoverResources(
                in: $resourcesPath,
                for: 'App\\Filament\\Resources',
            );
        }

        if (is_dir($pagesPath)) {
            $panel = $panel->discoverPages(
                in: $pagesPath,
                for: 'App\\Filament\\Pages',
            );
        }

        $panel = $panel->pages([
            MainDashboard::class,
            MyProfilePage::class,
        ]);

        if (is_dir($widgetsPath)) {
            $panel = $panel->discoverWidgets(
                in: $widgetsPath,
                for: 'App\\Filament\\Widgets',
            );
        }
        $panel = $panel
            ->widgets([
                // Widgets\AccountWidget::class,
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
            ])
            // Fix "This page has expired" (Livewire) sulla pagina di login del
            // panel admin principale: vedi spiegazione e riproduzione in
            // Modules/Xot/docs/stories/login-page-expired-investigation-2026-09-11.story.md
            // (stessa causa/fix di XotBasePanelProvider — questa classe non lo
            // estende, e' un provider separato per il panel 'admin' root).
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => <<<'HTML'
                    <script>
                        window.addEventListener('pageshow', function (event) {
                            if (event.persisted) {
                                window.location.reload();
                            }
                        });
                    </script>
                    HTML,
                scopes: Login::class,
            )
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => app(GetSidebarStateScriptAction::class)->execute(),
            );
        $navs = app(GetModulesNavigationItems::class)->execute();
        /*  4 debug
        $navs=[
            NavigationItem::make('Analytics')
                ->url('https://filament.pirsch.io', shouldOpenInNewTab: true)
                ->icon(Heroicon::OutlinedPresentationChartLine)
                ->group('Reports')
                ->sort(3),
            NavigationItem::make('dashboard')
                ->label(fn (): string => __('filament-panels::pages/dashboard.title'))
                ->url(fn (): string => Dashboard::getUrl())
                ->isActiveWhen(fn () => original_request()->routeIs('filament.admin.pages.dashboard')),
            // ...
        ];
         */
        $panel->navigationItems($navs);

        // Temporaneamente disabilitato per debug tenancy
        // $profile_url = MyProfilePage::getUrl(panel: $panel->getId());
        $profile_url = '#';

        $profileLabelRaw = __('user::default.profile.my_profile');
        $profileLabel = is_string($profileLabelRaw) ? $profileLabelRaw : null;

        $panel->userMenuItems([
            Action::make('profile')
                ->label($profileLabel)
                ->url($profile_url)
                ->icon('heroicon-o-user'),
        ]);

        return $panel;
    }
}
