<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Pages;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Modules\Lang\Actions\ListLocaleOptionsAction;
use Modules\Lang\Datas\LangConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Lang (`config/{tenant}/lang.php`), solo super-admin: in che lingue si
 * modificano le traduzioni. Le scelte sono le lingue note al progetto (`laravellocalization`).
 *
 * @see LangConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, CheckboxList|Select>
     */
    protected function getFormSchema(): array
    {
        $options = app(ListLocaleOptionsAction::class)->execute();

        return [
            'default_locale' => Select::make('default_locale')->options($options),
            'supported_locales' => CheckboxList::make('supported_locales')->options($options)->required()->minItems(1),
        ];
    }
}
