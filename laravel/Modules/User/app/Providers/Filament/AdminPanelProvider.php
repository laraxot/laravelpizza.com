<?php

declare(strict_types=1);

namespace Modules\User\Providers\Filament;

use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Modules\User\Filament\Widgets\Auth\SocialLoginWidget;
use Modules\User\Filament\Widgets\Profile\SuperAdminWidget;
use Modules\User\Filament\Widgets\Team\TeamChangeWidget;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'User';

    #[\Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            static fn (): string => Blade::render("@livewire('".SocialLoginWidget::class."')"),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            static fn (): string => Blade::render("@livewire('".TeamChangeWidget::class."')"),
        );

        FilamentView::registerRenderHook(
            PanelsRenderHook::USER_MENU_BEFORE,
            static fn (): string => Blade::render("@livewire('".SuperAdminWidget::class."')"),
        );

        return $panel;
    }
}
