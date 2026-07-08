<?php

declare(strict_types=1);

namespace Modules\Progressioni\Providers\Filament;

use Filament\Panel;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;
use Override;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Progressioni';

    /**
     * Configura il panel Filament per il modulo Progressioni.
     *
     * ✅ Registra SpatieTranslatablePlugin per supporto MailTemplateResource
     *    che estende LangBaseResource (richiede il plugin).
     */
    #[Override]
    public function panel(Panel $panel): Panel
    {
        // ✅ Registrazione plugin per supporto multilingua
        // Richiesto da MailTemplateResource che estende LangBaseResource
        $panel->plugins([
            SpatieTranslatablePlugin::make()
                ->defaultLocales(['it', 'en']),
        ]);

        return parent::panel($panel);
    }
}
