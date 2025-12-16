<?php

declare(strict_types=1);

namespace Modules\Geo\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Filament\Widgets\EnvWidget;

class SettingPage extends XotBasePage
{
    public function getHeaderWidgets(): array
    {
        $only = [
            'debugbar_enabled',
            'google_maps_api_key',
        ];

        return [
            EnvWidget::make(['only' => $only]),
        ];
    }
}
