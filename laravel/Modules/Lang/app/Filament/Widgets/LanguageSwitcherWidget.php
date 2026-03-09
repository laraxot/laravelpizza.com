<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Widgets;

use Illuminate\Support\Collection;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

class LanguageSwitcherWidget extends XotBaseWidget
{
    protected string $view = 'lang::filament.widgets.language-switcher';

    public function getFormSchema(): array
    {
        return [];
    }

    public function getAvailableLocales(): Collection
    {
        return collect($this->getDefaultLanguages());
    }

    public function changeLanguage(string $locale): void
    {
        session(['locale' => $locale]);
        app()->setLocale($locale);
        $this->redirect(request()->header('Referer') ?? '/');
    }

    protected function getViewData(): array
    {
        return [
            'current_locale' => app()->getLocale(),
            'available_locales' => $this->getAvailableLocales(),
            'widget_id' => 'language-switcher-'.uniqid(),
        ];
    }

    protected function getDefaultLanguages(): array
    {
        return [
            ['code' => 'it', 'name' => 'Italian', 'native_name' => 'Italiano', 'flag' => '🇮🇹'],
            ['code' => 'en', 'name' => 'English', 'native_name' => 'English', 'flag' => '🇬🇧'],
            ['code' => 'de', 'name' => 'German', 'native_name' => 'Deutsch', 'flag' => '🇩🇪'],
        ];
    }
}
