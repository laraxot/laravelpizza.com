<?php

declare(strict_types=1);

namespace Modules\Cms\Providers\Filament;

use Filament\Panel;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Cms';

    public function panel(Panel $panel): Panel
    {
        // Le risorse Page/Section/Menu usano Translatable (LocaleSwitcher): senza il plugin
        // "Plugin [spatie-translatable] is not registered for panel [cms::admin]".
        $panel->plugins([
            SpatieTranslatablePlugin::make()->defaultLocales(['it', 'en']),
        ]);

        return parent::panel($panel);
    }
}
