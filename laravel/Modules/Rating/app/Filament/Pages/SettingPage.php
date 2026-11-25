<?php

declare(strict_types=1);

namespace Modules\Rating\Filament\Pages;

use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Rating (`config/{tenant}/rating.php`), solo super-admin. Pagina senza campi: la
 * convenzione (Data, file del tenant, accesso) sta in BaseSettingPage e in
 * \Modules\Rating\Datas\RatingConfigData.
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, never>
     */
    protected function getFormSchema(): array
    {
        return [];
    }
}
