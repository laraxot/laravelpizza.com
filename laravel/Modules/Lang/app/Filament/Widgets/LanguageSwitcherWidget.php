<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Support\Collection;
use Mcamara\LaravelLocalization\Exceptions\UnsupportedLocaleException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * Widget per il cambio di lingua.
 *
 * Fornisce un selettore dropdown per cambiare la lingua dell'interfaccia.
 * Sostituisce i vecchi componenti HTTP `Http\Livewire\Lang\{Switcher,Change}`:
 * stessa fonte lingue (`LaravelLocalization::getSupportedLocales()`) e stessa
 * strategia di URL localizzato (`LaravelLocalization::getLocalizedURL()`), non
 * più un fallback statico né un redirect sull'URL corrente non localizzato.
 *
 * @see https://github.com/mcamara/laravel-localization
 */
class LanguageSwitcherWidget extends XotBaseSchemaWidget
{
    /** @var view-string */
    protected string $view = 'lang::filament.widgets.language-switcher';

    /**
     * Non è una dashboard card: si monta esplicitamente nel tema
     * (`@livewire(\Modules\Lang\Filament\Widgets\LanguageSwitcherWidget::class)`),
     * non va auto-scoperto nelle dashboard Filament.
     */
    protected static bool $isDiscovered = false;

    /**
     * Determina se il widget può essere visualizzato.
     */
    public static function canView(): bool
    {
        return true;
    }

    /**
     * Schema del form: il widget non espone campi editabili, solo azioni.
     *
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }

    /**
     * Metodo pubblico per esporre i dati della vista ad altri componenti.
     *
     * @return array<string, mixed>
     */
    public function exposeViewData(): array
    {
        return $this->getViewData();
    }

    /**
     * Ottiene le lingue disponibili nel sistema da LaravelLocalization,
     * la stessa fonte usata dai vecchi `Switcher`/`Change`.
     *
     * @return Collection<int, array{code: string, name: string, native_name: string, flag: string|null}>
     */
    public function getAvailableLocales(): Collection
    {
        /** @var array<string, array<string, mixed>> $supportedLocales */
        $supportedLocales = LaravelLocalization::getSupportedLocales();

        return collect($supportedLocales)
            ->map(function (array $properties, string $code): array {
                $name = $properties['name'] ?? $code;

                return [
                    'code' => $code,
                    'name' => is_string($name) ? $name : $code,
                    'native_name' => is_string($properties['native'] ?? null)
                        ? $properties['native']
                        : (is_string($name) ? $name : $code),
                    'flag' => is_string($properties['flag'] ?? null) ? $properties['flag'] : null,
                ];
            })
            ->values();
    }

    /**
     * Cambia la lingua corrente e reindirizza all'URL localizzato
     * equivalente (stesso comportamento del vecchio `Change::mount()`),
     * non a un URL non localizzato con sola preferenza in sessione.
     */
    public function changeLanguage(string $locale): void
    {
        if (! $this->isValidLocale($locale)) {
            return;
        }

        $this->redirect($this->getLanguageUrl($locale));
    }

    /**
     * Genera l'URL localizzato per una specifica lingua tramite
     * `LaravelLocalization::getLocalizedURL()`. Fallback a `/{locale}`
     * se il pacchetto non riesce a produrre una stringa (es. mock nei test)
     * o se il locale richiesto non è tra quelli davvero supportati in
     * configurazione (`UnsupportedLocaleException`).
     */
    public function getLanguageUrl(string $locale): string
    {
        try {
            $url = LaravelLocalization::getLocalizedURL($locale, null, [], true);
        } catch (UnsupportedLocaleException) {
            return '/'.$locale;
        }

        return is_string($url) ? $url : '/'.$locale;
    }

    /**
     * Dati da passare alla vista FO (`lang::filament.widgets.language-switcher`):
     * `$lang` (codice lingua corrente, per l'icona nel pulsante) e `$langs`
     * (mappa `codice => ['url' => ..., 'native' => ...]` per i link `<a href>`
     * del dropdown, con URL già localizzati via `getLanguageUrl()`).
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $availableLocales = $this->getAvailableLocales();

        $langs = $availableLocales->mapWithKeys(fn (array $locale): array => [
            $locale['code'] => [
                'url' => $this->getLanguageUrl($locale['code']),
                'native' => $locale['native_name'],
            ],
        ]);

        return [
            'available_locales' => $availableLocales,
            'lang' => app()->getLocale(),
            'langs' => $langs,
        ];
    }

    /**
     * Verifica se il locale è valido (presente tra quelli supportati).
     */
    protected function isValidLocale(string $locale): bool
    {
        return $this->getAvailableLocales()->contains('code', $locale);
    }
}
