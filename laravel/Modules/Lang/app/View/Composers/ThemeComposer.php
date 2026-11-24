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
     *
     * @return DataCollection<int, LangData>
     *
     * @throws \Exception if supportedLocales config is not an array
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

        $languages = collect($langs)->map(function (mixed $item, int|string $key): array {
            $locale = (string) $key;

            // `supportedLocales` e' configurazione scritta a mano, quindi il
            // valore non e' necessariamente un array. Dichiararlo `array` nella
            // firma della closure non lo rendeva tale: lo faceva diventare un
            // «Argument #1 ($item) must be of type array, string given» lanciato
            // da dentro Arr::map, che non dice **quale** locale e' sbagliato —
            // l'unica cosa che serve sapere a chi deve correggere il file
            // (base_quaeris_fila5#234).
            if (! is_array($item)) {
                throw new \InvalidArgumentException(sprintf(
                    'Expected array at locale %s, got %s',
                    $locale,
                    get_debug_type($item),
                ));
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

            if ($regionalCode === 'en') {
                $regionalCode = 'gb';
            }

            $url = '#'; // Placeholder URL for frontend.
            if (inAdmin()) {
                $url = $this->buildAdminLanguageUrl($locale);
            }

            // Verifichiamo che name sia una stringa o lo convertiamo in modo sicuro
            $name = $item['name'];
            if (! is_string($name)) {
                $name = $locale; // Fallback al codice locale
            }

            return [
                'id' => $locale,
                'name' => $name,
                'flag' => $this->buildFlagHtml($regionalCode),
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
     * @return DataCollection<int, LangData>
     */
    public function otherLanguages(): DataCollection
    {
        $currentLocale = app()->getLocale();

        // `DataCollection::filter()` e' deprecata in spatie/laravel-data v5 («use a
        // regular Laravel collection instead»). Il filtro passa quindi da
        // `toCollection()`, e il risultato viene ricomposto in DataCollection perche'
        // e' quello che il tipo di ritorno e i chiamanti dichiarano.
        $others = $this->languages()
            ->toCollection()
            ->filter(static fn (LangData $item): bool => $item->id !== $currentLocale)
            ->values()
            ->all();

        /** @var DataCollection<int, LangData> $collection */
        $collection = LangData::collect($others, DataCollection::class);

        return $collection;
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
        $lang = $this->languages()->toCollection()->firstWhere('id', $currentLocale);

        if (! $lang instanceof LangData) {
            throw new \Exception(sprintf('Current language not found on line %d in %s', __LINE__, class_basename($this)));
        }

        // Verifichiamo che il valore del campo sia una stringa o lo convertiamo in modo sicuro
        $value = $this->langFieldValue($lang, $field);
        if (! is_string($value)) {
            return $field === 'id' ? $currentLocale : '';
        }

        return $value;
    }

    /**
     * Legge dal LangData il campo richiesto.
     *
     * ## Perche' `mixed`, che di norma non si usa
     *
     * `$field` e' un parametro, quindi la proprieta' letta non e' nota mentre si
     * scrive: `LangData` dichiara `id`, `name`, `flag` e `url` tutte `string`,
     * ma un blade puo' chiedere un nome che non e' fra quelli. Dichiarare
     * `string` sarebbe quindi una promessa che questo metodo non e' in grado di
     * mantenere, e il controllo `is_string()` del chiamante — che e' corretto,
     * perche' `currentLang()` deve restituire una stringa a chiunque — non
     * avrebbe piu' senso di esistere.
     *
     * ## Perche' e' un metodo
     *
     * Per rendere raggiungibile quel controllo in un test senza inventare un
     * `LangData` malformato. La fixture
     * `Modules\Lang\Tests\Fixtures\ThemeComposerNonStringFieldStub` lo
     * sovrascriveva **gia'** restituendo `42`, ma qui non esisteva: l'override
     * era inerte e il test leggeva il campo vero, ottenendo «Italiano» dove
     * attendeva la stringa vuota (base_quaeris_fila5#234).
     */
    protected function langFieldValue(LangData $lang, string $field): mixed
    {
        return $lang->{$field};
    }

    /**
     * Build the URL for the admin panel based on the current route and parameters.
     *
     * @param  string  $locale  The locale code to build URL for
     * @return string The generated URL
     */
    public function buildAdminLanguageUrl(string $locale): string
    {
        $routeName = Route::currentRouteName();
        if (! is_string($routeName)) {
            return '#';
        }
        $routeParameters = array_merge(Route::current()?->parameters() ?? [], ['lang' => $locale]);
        $queryParameters = request()->all();

        $url = route($routeName, $routeParameters);

        return Request::create($url)->fullUrlWithQuery($queryParameters);
    }

    /**
     * Build the HTML for the language flag.
     *
     * @param  string  $regionalCode  The regional code for the flag
     * @return string The HTML for the flag
     */
    private function buildFlagHtml(string $regionalCode): string
    {
        return sprintf('<div class="iti__flag-box"><div class="iti__flag iti__%s"></div></div>', e($regionalCode));
    }
}
