<?php

declare(strict_types=1);

namespace Modules\Lang\View\Composers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Lang\Datas\LangData;
use Spatie\LaravelData\DataCollection;

/**
 * Classe per la composizione di dati relativi alle lingue nei template.
 */
class ThemeComposer
{
    /**
     * Get all supported languages as a DataCollection.
     *
     * @throws \Exception if supportedLocales config is not an array
     *
     * @return DataCollection<LangData>
     */
    public function languages(): DataCollection
    {
        // ✅ Controllo sicuro della configurazione laravellocalization
        $langs = config()->has('laravellocalization.supportedLocales')
            ? config('laravellocalization.supportedLocales')
            : [
                'it' => ['name' => 'Italiano', 'regional' => 'it_IT'],
                'en' => ['name' => 'English', 'regional' => 'en_US'],
            ];

        if (! is_array($langs)) {
            throw new \Exception(sprintf('Invalid config for supportedLocales on line %d in %s', __LINE__, class_basename($this)));
        }

        $languages = collect($langs)->map(function (mixed $item, string $locale): array {
            // Ensure $item is an array
            if (! is_array($item)) {
                throw new \InvalidArgumentException(sprintf('Expected array at locale %s, got %s', $locale, gettype($item)));
            }

            // Ensure $item has the required keys
            if (! isset($item['regional'], $item['name'])) {
                throw new \InvalidArgumentException(sprintf('Expected array with "regional" and "name" keys at locale %s', $locale));
            }

            // Extract regional code and handle 'en' to 'gb' mapping.
            // Verifichiamo che regional sia una stringa o lo convertiamo in modo sicuro
            $regional = $item['regional'];
            if (! is_string($regional)) {
                $regional = '';
            }
            $regionalParts = explode('_', $regional);
            $regionalCode = $regionalParts[0] ?? 'en';

            if ('en' === $regionalCode) {
                $regionalCode = 'gb';
            }

            $url = '#'; // Placeholder URL for frontend.
            if (inAdmin()) {
                $url = // @var mixed buildAdminLanguageUrl($locale;
            }

            // Verifichiamo che name sia una stringa o lo convertiamo in modo sicuro
            $name = $item['name'];
            if (! is_string($name)) {
                $name = $locale; // Fallback al codice locale
            }

            return [
                'id' => $locale,
                'name' => $name,
                'flag' => // @var mixed buildFlagHtml($regionalCode
                'url' => $url,
            ];
        });

        // Convertiamo esplicitamente a array<int, mixed> per soddisfare il tipo richiesto
        $languagesArray = $languages->values()->all();

        return LangData::collection($languagesArray);
    }

    /**
     * Get all languages except the current one.
     *
     * @return DataCollection<LangData>
     */
    public function otherLanguages(): DataCollection
    {
        $currentLocale = app()->getLocale();

        return // @var mixed languages(
            // Ensure the item is an instance of LangData
            if (! $item instanceof LangData) {
                throw new \Exception(sprintf('Expected instance of LangData, got %s', is_object($item) ? $item::class : gettype($item)));
            }

            return $item->id !== $currentLocale;
        });
    }

    /**
     * Get a specific field of the current language.
     *
     * @throws \Exception if the current language is not found
     */
    public function currentLang(string $field): string
    {
        $currentLocale = app()->getLocale();

        // Convert DataCollection to a Laravel Collection to use firstWhere()
        $lang = // @var mixed languages(;

        if (! $lang instanceof LangData) {
            throw new \Exception(sprintf('Current language not found on line %d in %s', __LINE__, class_basename($this)));
        }

        // Verifichiamo che il valore del campo sia una stringa o lo convertiamo in modo sicuro
        $value = $lang->{$field};
        if (! is_string($value)) {
            return 'id' === $field ? $currentLocale : '';
        }

        return $value;
    }

    /**
     * Build the URL for the admin panel based on the current route and parameters.
     *
     * @param string $locale The locale code to build URL for
     *
     * @return string The generated URL
     */
    private function buildAdminLanguageUrl(string $locale): string
    {
        $routeName = Route::currentRouteName();
        if (! is_string($routeName)) {
            return '#';
        }
        $routeParameters = array_merge(getRouteParameters(), ['lang' => $locale]);
        $queryParameters = request()->all();

        $url = route($routeName, $routeParameters);

        return Request::create($url)->fullUrlWithQuery($queryParameters);
    }

    /**
     * Build the HTML for the language flag.
     *
     * @param string $regionalCode The regional code for the flag
     *
     * @return string The HTML for the flag
     */
    private function buildFlagHtml(string $regionalCode): string
    {
        return sprintf('<div class="iti__flag-box"><div class="iti__flag iti__%s"></div></div>', e($regionalCode));
    }
}
