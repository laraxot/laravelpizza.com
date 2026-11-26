<?php

declare(strict_types=1);

namespace Modules\Lang\Providers\Filament;

use Filament\Panel;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Lang';

    /**
     * Aggiunge SpatieTranslatable al pannello admin Lang.
     *
     * @see Modules/Lang/docs/filament-auto-labels.md
     */
    #[\Override]
    public function panel(Panel $panel): Panel
    {
        return parent::panel($panel)->plugins([
            SpatieTranslatablePlugin::make()->defaultLocales(['en', 'it']),
        ]);
    }
}
