<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Modules\Cms\Actions\ListInstalledThemesAction;
use Modules\Cms\Datas\CmsConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Cms: tema del sito pubblico e registrazione del tema.
 *
 * Salva in `config/{tenant}/xra.php` (le chiavi vivono lì per compatibilità con XotData).
 *
 * @see CmsConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, Select|Toggle>
     */
    protected function getFormSchema(): array
    {
        $themes = $this->getAvailableThemes();

        return [
            'pub_theme' => Select::make('pub_theme')
                ->options($themes)
                ->searchable()
                ->required(),

            'register_pub_theme' => Toggle::make('register_pub_theme'),

        ];
    }

    /**
     * Temi disponibili: le directory di `Themes/` che esistono fisicamente.
     *
     * @return array<string, string>
     */
    private function getAvailableThemes(): array
    {
        return app(ListInstalledThemesAction::class)->execute();
    }
}
