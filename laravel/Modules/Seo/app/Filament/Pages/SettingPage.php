<?php

declare(strict_types=1);

namespace Modules\Seo\Filament\Pages;

use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Modules\Seo\Datas\SeoConfigData;
use Modules\Xot\Filament\Pages\BaseSettingPage;

/**
 * Impostazioni di Seo (`config/{tenant}/seo.php`), solo super-admin: gli alias delle pagine doppie.
 *
 * @see SeoConfigData
 */
class SettingPage extends BaseSettingPage
{
    /**
     * @return array<string, Repeater>
     */
    protected function getFormSchema(): array
    {
        return [
            'path_aliases' => Repeater::make('path_aliases')
                ->schema([
                    TextInput::make('alias')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('target')
                        ->maxLength(255),
                ])
                ->columns(2)
                ->defaultItems(0)
                ->rules([$this->pathAliasesRule(...)]),
        ];
    }

    /**
     * Segnala le righe che il sito ignorerebbe (giri, catene, alias ripetuti) invece di salvarle in silenzio.
     *
     * @param  Closure(string): mixed  $fail
     */
    protected function pathAliasesRule(string $attribute, mixed $value, Closure $fail): void
    {
        if (SeoConfigData::from(['path_aliases' => $value])->hasRejectedAliases()) {
            $fail(__('seo::setting.errors.path_aliases'));
        }
    }
}
