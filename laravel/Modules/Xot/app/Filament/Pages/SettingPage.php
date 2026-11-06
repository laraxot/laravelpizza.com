<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Modules\Xot\Actions\ListMainModuleCandidatesAction;
use Modules\Xot\Actions\ListSupportedLocalesAction;
use Modules\Xot\Datas\XotConfigData;

/**
 * Impostazioni di Xot (`config/{tenant}/xra.php`), solo super-admin.
 *
 * Il modulo principale e la lingua primaria si scelgono tra quelli che esistono (moduli con pannello,
 * lingue supportate), cosi' un valore sbagliato non puo' togliere il pannello predefinito.
 * I temi non sono qui: li imposta Cms.
 *
 * @see XotConfigData
 */
class SettingPage extends BaseSettingPage
{
    public static function getConfigName(): string
    {
        return XotConfigData::tenantConfigName();
    }

    /**
     * @return array<string, Select|Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'main_module' => Select::make('main_module')
                ->options(app(ListMainModuleCandidatesAction::class)->execute())
                ->required(),
            'primary_lang' => Select::make('primary_lang')
                ->options(app(ListSupportedLocalesAction::class)->execute())
                ->required(),
            'force_ssl' => Toggle::make('force_ssl'),
            'disable_database_notifications' => Toggle::make('disable_database_notifications'),
        ];
    }
}
