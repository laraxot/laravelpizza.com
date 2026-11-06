<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Modules\Job\Datas\JobConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Job (`config/{tenant}/job.php`), solo super-admin: con quali opzioni
 * `worker:check` avvia il worker della coda.
 *
 * @see JobConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, TextInput>
     */
    protected function getFormSchema(): array
    {
        return [
            'max_attempts' => TextInput::make('max_attempts')->numeric()->integer()->minValue(1)->maxValue(20)->required(),
            'timeout_seconds' => TextInput::make('timeout_seconds')->numeric()->integer()->minValue(1)->maxValue(3600)->required(),
            'sleep_seconds' => TextInput::make('sleep_seconds')->numeric()->integer()->minValue(1)->maxValue(60)->required(),
        ];
    }
}
