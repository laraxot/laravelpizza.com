<?php

declare(strict_types=1);

namespace Modules\Notify\Providers\Filament;

use Filament\Notifications\Livewire\DatabaseNotifications;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Override;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Notify';

    #[Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Temporaneamente commentato per compatibilità Filament 4.x
        // $panel->plugins([
        //     SpatieTranslatablePlugin::make(),
        // ]);

        if (!XotData::make()->disable_database_notifications) {
            DatabaseNotifications::trigger('notify::livewire.database-notifications-trigger');
            // DatabaseNotifications::databaseNotificationsPollingInterval('30s');
            DatabaseNotifications::pollingInterval('60s');
            FilamentView::registerRenderHook('panels::user-menu.before', static fn (): string => Blade::render(
                '@livewire(\'database-notifications\')',
            ));
        }

        return $panel;
    }
}
