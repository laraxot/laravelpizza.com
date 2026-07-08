<?php

declare(strict_types=1);

namespace Modules\Lang\Providers\Filament;

use Filament\Panel;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

abstract class LangBasePanelProvider extends XotBasePanelProvider
{
    protected string $module = 'Lang';

    #[\Override]
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        // FilamentAsset::register(
        //     [
        //         Css::make('filament-navigation-styles', __DIR__.'/../../resources/dist/plugin.css'),
        //         Js::make('filament-navigation-scripts', __DIR__.'/../../resources/dist/plugin.js'),
        //     ],
        //     'filament-navigation'
        // );

        $spatieLaravelTranslatablePlugin = SpatieTranslatablePlugin::make()->defaultLocales(['en', 'it']);
        $panel->plugins([
            $spatieLaravelTranslatablePlugin,
        ]);

        return $panel;
    }
}
