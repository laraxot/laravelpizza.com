<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

use Modules\Xot\Filament\Pages\BaseSettingPage;
use Modules\Xot\Filament\Widgets\EnvWidget;

/**
 * Impostazioni di Geo (`config/{tenant}/geo.php`), solo super-admin.
 *
 * Form configurato con i campi esposti da GeoConfigData.
 *
 * @see GeoConfigData
 */
final class SettingPage extends BaseSettingPage
{
    /**
     * Keep the existing environment diagnostics alongside tenant settings.
     *
     * @return array<int, object>
     */
    public function getHeaderWidgets(): array
    {
        return [
            EnvWidget::make([
                'only' => [
                    'debugbar_enabled',
                    'google_maps_api_key',
                ],
            ]),
        ];
    }

    /**
     * @return array<string, object>
     */
    protected function getFormSchema(): array
    {
        return parent::getFormSchema();
    }
}
