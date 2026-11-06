<?php

declare(strict_types=1);

namespace Modules\Gdpr\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Modules\Gdpr\Datas\GdprConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Gdpr: validità della scelta cookie e pagina policy.
 *
 * Il Garante (provv. 10.6.2021 n. 231) non ammette di riproporre il banner prima di 6 mesi:
 * il campo `consent_lifetime` non accetta meno di 180 giorni.
 *
 * @see GdprConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, TextInput>
     */
    protected function getFormSchema(): array
    {
        return [
            'consent_lifetime' => TextInput::make('consent_lifetime')
                ->numeric()
                ->integer()
                ->minValue(180)
                ->required(),

            'policy_path' => TextInput::make('policy_path')
                ->required()
                ->prefix('/')
                ->maxLength(255),
        ];
    }
}
