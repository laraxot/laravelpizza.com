<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Pages;

use Filament\Forms\Components\Toggle;
use Modules\UI\Datas\UIConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di UI (`config/{tenant}/ui.php`), solo super-admin: visibilita' del selettore tema
 * chiaro/scuro.
 *
 * @see UIConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'dark_mode_switcher_enabled' => Toggle::make('dark_mode_switcher_enabled'),
        ];
    }
}
