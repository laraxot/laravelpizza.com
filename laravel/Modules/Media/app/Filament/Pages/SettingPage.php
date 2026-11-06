<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Pages;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Modules\Media\Actions\Upload\GetEffectiveUploadLimitAction;
use Modules\Media\Datas\MediaConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Media (`config/{tenant}/media.php`), solo super-admin: dimensione massima e tipi accettati degli allegati delle Resource.
 *
 * @see MediaConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, TagsInput|TextInput>
     */
    protected function getFormSchema(): array
    {
        return [
            'attachment_max_size_kb' => TextInput::make('attachment_max_size_kb')
                ->numeric()
                ->integer()
                ->minValue(1)
                ->maxValue(fn (): int => intdiv(app(GetEffectiveUploadLimitAction::class)->execute(), 1024))
                ->required(),
            'attachment_mime_types' => TagsInput::make('attachment_mime_types')
                ->nestedRecursiveRules(['regex:#^[a-z0-9.+-]+/([a-z0-9.+-]+|\*)$#i'])
                ->required(),
        ];
    }
}
