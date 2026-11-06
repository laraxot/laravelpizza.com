<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Actions;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\App;
use Modules\Lang\Actions\ListLocaleOptionsAction;
use Modules\Lang\Actions\ResolveDefaultTranslatableLocaleAction;
use Modules\Lang\Actions\ResolveTranslatableLocalesAction;
use Modules\Xot\Filament\Actions\XotBaseAction;

class LocaleSwitcherRefresh extends XotBaseAction
{
    public string $fullUrl = '#';

    public string $lang = '';

    protected function setUp(): void
    {
        parent::setUp();
        $languageOptions = app(ListLocaleOptionsAction::class)->execute(app(ResolveTranslatableLocalesAction::class)->execute());
        $lang = session()->get('locale');
        if (! is_string($lang)) {
            $lang = app(ResolveDefaultTranslatableLocaleAction::class)->execute('it');
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
                    ->live()
                    ->required(),
            ])
            ->action(function (array $data) {
                $this->applyLocale(self::normalizeLocale($data['locale'] ?? null));

                return redirect(request()->header('Referer'));
            })
            ->modalHeading('Cambia lingua')
            // ->icon('heroicon-o-language')
            ->color('gray');
    }

    /**
     * Coerce l'input form (mixed) a una locale stringa.
     *
     * Scopo: tenere il bordo Filament separato dal contratto di dominio
     * {@see applyLocale()}. Fallback `en` se il valore non e' stringa.
     */
    public static function normalizeLocale(mixed $raw): string
    {
        return \is_string($raw) ? $raw : 'en';
    }

    /**
     * Applica la lingua scelta a sessione e applicazione.
     *
     * Scopo: un solo contratto di dominio — una stringa locale — non un blob form.
     * Estratto dalla closure di `->action()` per renderlo verificabile senza montare
     * Filament ne' simulare una richiesta HTTP.
     */
    public function applyLocale(string $locale): void
    {
        session()->put('locale', $locale);
        App::setLocale($locale);
    }
}
