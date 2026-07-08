<?php

declare(strict_types=1);

namespace Modules\Ptv\Providers\Filament;

use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Override;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Ptv';

    #[Override]
    public function panel(Panel $panel): Panel
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::BODY_END,
            static fn (): string => Blade::render("@component('xot::x-debug')"),
            // static fn (): string => 'qui',
        );

        return parent::panel($panel);
    }
}
