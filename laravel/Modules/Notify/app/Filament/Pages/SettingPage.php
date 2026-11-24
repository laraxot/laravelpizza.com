<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Widgets\WidgetConfiguration;
use Modules\Notify\Datas\NotifyConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;
use Modules\Xot\Filament\Widgets\EnvWidget;

/**
 * Impostazioni operative Notify: configurazione tenant tramite BaseSettingPage
 * e valori infrastrutturali/segreti del file `.env` tramite EnvWidget.
 * I due percorsi restano distinti: i segreti non vengono copiati nella config tenant.
 *
 * @see NotifyConfigData
 */
class SettingPage extends BaseSettingPage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'notify::filament.pages.setting';

    /**
     * Pulizia dei log ed endpoint FCM. Il segreto `fcm.server_key` non
     * e' un campo: EnvWidget (header) gestisce solo le chiavi `.env` selezionate.
     *
     * @return array<string, TextInput|Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'cleanup_enabled' => Toggle::make('cleanup_enabled'),
            'cleanup_older_than_days' => TextInput::make('cleanup_older_than_days')
                ->numeric()
                ->integer()
                ->minValue(1)
                ->required(),
            'cleanup_batch_size' => TextInput::make('cleanup_batch_size')
                ->numeric()
                ->integer()
                ->minValue(1)
                ->maxValue(10000)
                ->required(),
            'cleanup_keep_failed' => Toggle::make('cleanup_keep_failed'),
            'fcm_url' => TextInput::make('fcm_url')
                ->url()
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * @return list<WidgetConfiguration>
     */
    public function getHeaderWidgets(): array
    {
        $only = [
            'debugbar_enabled',
            // 'google_maps_api_key',
            'telegram_bot_token',
            'sms_driver',
            'netfun_token',
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_encryption',
            'mail_username',
            'mail_password',
            'mail_from_address',
            'mail_from_name',
        ];

        return [
            EnvWidget::make(['only' => $only]),
        ];
    }
}
