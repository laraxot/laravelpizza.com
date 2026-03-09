<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Actions;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\App;

class LocaleSwitcherRefresh extends Action
{
    public string $fullUrl = '#';

    public string $lang = '';

    protected function setUp(): void
    {
        parent::setUp();
        $languageOptions = [
            'en' => '🇬🇧 English',
            'it' => '🇮🇹 Italiano',
        ];
        $lang = session()->get('locale');
        if (! is_string($lang)) {
            $lang = 'it';
        }
        app()->setLocale($lang);
        $this->lang = app()->getLocale();
        $this->fullUrl = request()->fullUrl();
        $this->label($this->lang)
            ->schema([
                Select::make('locale')
                    ->label('Seleziona lingua')
                    ->options($languageOptions)
                    ->default($this->lang)
                    ->reactive()
                    ->required(),
            ])
            ->action(function (array $data) {
                $locale = $data['locale'] ?? 'en';
                $locale = is_string($locale) ? $locale : 'en';

                session()->put('locale', $locale);
                App::setLocale($locale);
                // Filament::setLocale($locale);

                return redirect(request()->header('Referer'));
            })
            ->modalHeading('Cambia lingua')
            // ->icon('heroicon-o-language')
            ->color('gray');
    }
}
