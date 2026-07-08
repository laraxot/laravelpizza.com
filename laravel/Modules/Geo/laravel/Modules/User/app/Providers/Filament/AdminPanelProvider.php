<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\User\Providers\Filament;

use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'User';

    #[\Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        FilamentView::registerRenderHook('panels::auth.login.form.after', static fn (): string => Blade::render(
            "@livewire('socialite.buttons')",
        ));

        /*-- moved into Gdpr
         * FilamentView::registerRenderHook(
         * 'panels::auth.login.form.after',
         * fn (): string => Blade::render('@livewire(\'terms-of-service\')'),
         * );
         */

        /* -- moved into Notify
         * DatabaseNotifications::trigger('notifications.database-notifications-trigger');
         * FilamentView::registerRenderHook(
         * 'panels::user-menu.before',
         * fn (): string => Blade::render('@livewire(\'database-notifications\')'),
         * );
         * //*/

        FilamentView::registerRenderHook('panels::user-menu.before', static fn (): string => Blade::render(
            "@livewire('team.change')",
        ));

        FilamentView::registerRenderHook(
            'panels::user-menu.before',
            // static fn (): string => View::make('user::badges.super-admin')->render(),
            static fn (): string => Blade::render("@livewire('profile.super-admin')"),
        );

        /*
         * $panel->renderHook(
         * 'panels::user-menu.before',
         * fn (): string => Blade::render('@livewire(\'team.change\')'),
         * );
         */
        // $tenantId = request()->route()->parameter('tenant');
        // $profile_url = MyProfilePage::getUrl(panel: 'admin');
        // $panel->default();
        // $profile_url = MyProfilePage::getUrl(panel: 'admin');
        // $panel = $panel->pages([
        //     MyProfilePage::class,
        // ]);
        // $profile_url = '#';
        // $panel->userMenuItems([
        //     // 'account' => MenuItem::make()->url($profile_url),
        //     MenuItem::make()

        //         ->url(fn (): string => '#')
        //         ->icon('heroicon-m-cog-8-tooth'),
        // ]);

        return $panel;
    }
}
