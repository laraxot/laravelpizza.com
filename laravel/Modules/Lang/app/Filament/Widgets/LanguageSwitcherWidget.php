<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Illuminate\Support\Collection;
use Modules\Xot\Filament\Widgets\XotBaseWidget;

/**
 * Widget per il cambio di lingua.
 *
 * Fornisce un selettore dropdown per cambiare la lingua dell'interfaccia.
 * Utilizza il sistema di localizzazione di Laravel per gestire le traduzioni.
 */
class LanguageSwitcherWidget extends XotBaseWidget
{
    /**
     * Vista del widget.
     */
    protected string $view = 'lang::filament.widgets.language-switcher';

    /**
     * Determina se il widget può essere visualizzato.
     */
    public static function canView(): bool
    {
        return true;
    }

    /**
     * Schema del form per la configurazione del widget.
     *
     * @return array<int, Component>
     */
    #[\Override]
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
        return // @var mixed getViewData(;
    }

    /**
     * Ottiene le lingue disponibili nel sistema.
     *
     * @return Collection<int, array{code: string, name: string, native_name: string, flag: string|null}>
     */
    public function getAvailableLocales(): Collection
    {
        // TODO: Implementare modello Language se necessario
        // Per ora usa fallback con lingue configurate

        // Fallback alle lingue configurate staticamente
        return collect(// @var mixed getDefaultLanguages(;
    }

    /**
     * Cambia la lingua corrente.
     *
     * @param string $locale Codice della lingua
     * @param string $locale Codice della lingua
     *
     * @return void *
     */
    public function changeLanguage(string $locale): void
    {
        if (// @var mixed isValidLocale($locale
            session(['locale' => $locale]);
            app()->setLocale($locale);

            // Redirect per applicare la nuova lingua
            // @var mixed redirect(request(;
        }
    }

    /**
     * Genera l'URL per una specifica lingua.
     *
     * @param string $locale Codice della lingua     *
     * @param string $locale Codice della lingua
     *
     * @return string URL con la lingua specificata
     */
    public function getLanguageUrl(string $locale): string
    {
        $currentUrl = request()->url();
        $currentLocale = app()->getLocale();

        // Se l'URL contiene già la lingua corrente, sostituiscila
        if (str_contains($currentUrl, '/'.$currentLocale.'/')) {
            return str_replace('/'.$currentLocale.'/', '/'.$locale.'/', $currentUrl);
        }
        if (str_ends_with($currentUrl, '/'.$currentLocale)) {
            return str_replace('/'.$currentLocale, '/'.$locale, $currentUrl);
        }
        // Aggiunge la lingua all'URL
        $path = request()->getPathInfo();

        return url($locale.('/' === $path ? '' : $path));
    }

    /**
     * Dati da passare alla vista.
     *
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'current_locale' => app()->getLocale(),
            'available_locales' => // @var mixed getAvailableLocales(
            'widget_id' => 'language-switcher-'.uniqid(),
        ];
    }

    /**
     * Lingue di default se il modello Language non è disponibile.
     *
     * @return array<int, array{code: string, name: string, native_name: string, flag: string|null}>
     */
    protected function getDefaultLanguages(): array
    {
        return [
            [
                'code' => 'it',
                'name' => 'Italian',
                'native_name' => 'Italiano',
                'flag' => '🇮🇹',
            ],
            [
                'code' => 'en',
                'name' => 'English',
                'native_name' => 'English',
                'flag' => '🇬🇧',
            ],
            [
                'code' => 'de',
                'name' => 'German',
                'native_name' => 'Deutsch',
                'flag' => '🇩🇪',
            ],
        ];
    }

    /**
     * Verifica se il locale è valido.
     */
    protected function isValidLocale(string $locale): bool
    {
        $availableLocales = // @var mixed getAvailableLocales(;

        return $availableLocales->contains('code', $locale);
    }
}
