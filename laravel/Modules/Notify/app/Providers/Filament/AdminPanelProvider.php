<?php

declare(strict_types=1);

namespace Modules\Notify\Providers\Filament;

use Filament\Notifications\Livewire\DatabaseNotifications;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Notify';

    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Richiesto da MailTemplateResource (estende LangBaseResource → pagine
        // LangBaseListRecords/LangBaseEditRecord). Il pacchetto ufficiale
        // lara-zeus/spatie-translatable 2.0.1 supporta Filament 5 — il vecchio
        // commento "compatibilità Filament 4.x" non è più valido. Stesso pattern
        // di Modules\Lang\Providers\Filament\LangBasePanelProvider.
        $panel->plugins([
            SpatieTranslatablePlugin::make()->defaultLocales(['en', 'it']),
        ]);

        if (! XotData::make()->disable_database_notifications) {
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
