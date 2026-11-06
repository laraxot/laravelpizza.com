<?php

declare(strict_types=1);

namespace Modules\Activity\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Modules\Activity\Datas\ActivityConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Activity: abilitazione log, retention, nome log, soft delete.
 *
 * @see ActivityConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, TextInput|Toggle>
     */
    protected function getFormSchema(): array
    {
        return [
            'enabled' => Toggle::make('enabled'),

            'clean_after_days' => TextInput::make('clean_after_days')
                ->numeric()
                ->integer()
                ->minValue(1)
                ->required(),

            'default_log_name' => TextInput::make('default_log_name')
                ->required()
                ->maxLength(64),

            'include_soft_deleted_subjects' => Toggle::make('include_soft_deleted_subjects'),
        ];
    }
}
