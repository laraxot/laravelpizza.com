<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Forms\Components;

use Illuminate\Support\Arr;
use Modules\Xot\Actions\File\AssetAction;
use Modules\Xot\Filament\Forms\Components\XotBaseSelect;

/**
 * National Flag Select Component.
 *
 * A Filament Select component that displays countries with their flags
 * and supports searching by country name using localized translations.
 *
 * ## Le due liste e i due agganci
 *
 * L'elenco dei paesi arriva dalla funzione globale `countries()` (rinvex), non
 * da una dipendenza iniettata. Una funzione globale non si sostituisce in un
 * test, quindi i due punti di variazione — da dove arrivano le righe e cosa
 * succede dopo il filtro — sono metodi sovrascrivibili: {@see resolveCountries()}
 * e {@see finalizeFilteredCountries()}.
 *
 * Esistono perche' le fixture del modulo li sovrascrivevano **gia'**
 * (`Modules\Lang\Tests\Fixtures\NationalFlagSelectFinalStub`) mentre qui non
 * c'erano: le sovrascritture erano inerti e i test che dichiaravano una riga
 * sola giravano in silenzio su tutti i 250 paesi veri. Un test la cui fixture
 * e' morta passa o fallisce per ragioni che non c'entrano con quello che dice
 * (base_quaeris_fila5#234).
 */
class NationalFlagSelect extends XotBaseSelect
{
    /**
     * Set up the component configuration.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->searchable()
            ->allowHtml()
            ->optionsLimit(300)
            ->native(false)
            ->options($this->getCountryOptions(...))
            ->getSearchResultsUsing($this->getFilteredCountryOptions(...));
    }

    /**
     * Get all country options with flags and localized names.
     *
     * @return array<string, string>
     */
    protected function getCountryOptions(): array
    {
        return $this->buildOptions($this->sortCountriesByName($this->resolveCountries()));
    }

    /**
     * Get filtered country options based on search query.
     *
     * @param  string  $search  The search query
     * @return array<string, string>
     */
    protected function getFilteredCountryOptions(string $search): array
    {
        if (trim($search) === '') {
            return $this->getCountryOptions();
        }

        $searchLower = strtolower($search);

        $filtered = array_filter(
            $this->resolveCountries(),
            fn (mixed $country): bool => $this->countryMatches($country, $searchLower),
        );

        return $this->buildOptions(
            $this->sortCountriesByName($this->finalizeFilteredCountries($filtered)),
        );
    }

    /**
     * Da dove arrivano le righe dei paesi.
     *
     * Aggancio per i test: `countries()` e' una funzione globale e non si
     * sostituisce nel container.
     *
     * @return array<array-key, mixed>
     */
    protected function resolveCountries(): array
    {
        return countries();
    }

    /**
     * Ultimo passaggio sulle righe filtrate, prima dell'ordinamento.
     *
     * Aggancio per i test, che da qui aggiungono righe sporche per verificare
     * le difese di {@see buildOptions()}.
     *
     * @param  array<array-key, mixed>  $filteredCountries
     * @return array<array-key, mixed>
     */
    protected function finalizeFilteredCountries(array $filteredCountries): array
    {
        return $filteredCountries;
    }

    /**
     * Costruisce le opzioni `codice => HTML` scartando le righe inutilizzabili.
     *
     * Era scritto due volte, identico, nei due metodi pubblici: nove righe
     * ripetute, con la gestione del caso non-stringa applicata in un solo
     * punto dei due.
     *
     * @param  array<array-key, mixed>  $countries
     * @return array<string, string>
     */
    private function buildOptions(array $countries): array
    {
        $options = [];

        foreach ($countries as $country) {
            if (! is_array($country)) {
                continue;
            }

            $code = $country['iso_3166_1_alpha2'] ?? null;
            if (! is_string($code) || $code === '') {
                continue;
            }

            $flagSrc = app(AssetAction::class)->execute('lang::svg/flag/'.strtolower($code).'.svg');
            $flag = '<img src="'.$flagSrc.'" class="h-4 w-6 mr-2" inline-block />';

            $options[$code] = '<span class="flex items-center gap-2">'
                .$flag
                .$this->countryLabel($code, $country)
                .'</span>';
        }

        return $options;
    }

    /**
     * L'etichetta localizzata del paese, sempre come stringa.
     *
     * ## Perche' non basta `__()`
     *
     * `__('lang::countries.'.$code)` ha come chiave un **dato**, non una
     * costante scritta nel codice: `$code` arriva da `countries()`. Una chiave
     * dinamica e' un input, e un input va validato, perche' `__()` restituisce
     * l'array del gruppo quando la chiave punta a un gruppo invece che a una
     * foglia. Concatenarlo dava `Array to string conversion` e un'etichetta
     * vuota.
     *
     * Con i file di lingua di oggi non succede — misurato: 250 paesi, zero
     * traduzioni non-stringa. Ma `Modules/Lang/lang/*\/countries.php` contiene
     * **gia'** tre chiavi di gruppo (`navigation`, `fields`, `actions`: i
     * metadati Filament della resource, finiti nello stesso file dei nomi dei
     * paesi). Il file e' quindi gia' stato modificato nella direzione che rompe
     * questo componente; serve solo che una delle prossime aggiunte usi un
     * codice di due lettere.
     *
     * ## Il ripiego
     *
     * Si usa il nome inglese della riga, e come ultima risorsa il codice:
     * mostrare "Italy" dove manca "Italia" e' peggio della traduzione giusta e
     * molto meglio di un'opzione senza etichetta.
     *
     * Non c'e' un ramo per i valori scalari — `(string) $label` per un `99`
     * dentro un file di lingua — perche' `__()` dichiara `string|array|null`:
     * un intero non e' nel contratto, quindi non c'e' niente da convertire.
     * Un decoratore del translator puo' comunque restituirlo a runtime, ed e'
     * cio' che fa il test «casts non-array non-string localized label»: quel
     * valore prende il ripiego come un gruppo, e l'opzione resta utilizzabile,
     * che e' quanto il test verifica davvero.
     *
     * @param  array<array-key, mixed>  $country
     */
    private function countryLabel(string $code, array $country): string
    {
        $label = __('lang::countries.'.strtolower($code));

        if (is_string($label)) {
            return $label;
        }

        $name = $country['name'] ?? null;

        return is_string($name) && $name !== '' ? $name : strtoupper($code);
    }

    /**
     * Una riga corrisponde alla ricerca per nome inglese, nome tradotto o codice.
     *
     * @param  mixed  $country  riga di `countries()`, non necessariamente un array
     */
    private function countryMatches(mixed $country, string $searchLower): bool
    {
        if (! is_array($country)) {
            return false;
        }

        $code = $country['iso_3166_1_alpha2'] ?? null;
        $name = $country['name'] ?? null;

        if (! is_string($code) || ! is_string($name)) {
            return false;
        }

        if (str_contains(strtolower($name), $searchLower)
            || str_contains(strtolower($code), $searchLower)) {
            return true;
        }

        // Il nome tradotto entra nella ricerca solo se e' una stringa: per la
        // stessa ragione spiegata in countryLabel().
        $localized = __('lang::countries.'.strtolower($code));

        return is_string($localized) && str_contains(strtolower($localized), $searchLower);
    }

    /**
     * Ordina le righe per nome inglese, tenendo in coda quelle senza nome.
     *
     * @param  array<array-key, mixed>  $countries
     * @return array<array-key, mixed>
     */
    private function sortCountriesByName(array $countries): array
    {
        return Arr::sort($countries, static function (mixed $country): string {
            if (! is_array($country)) {
                return '';
            }

            $name = $country['name'] ?? null;

            return is_string($name) ? $name : '';
        });
    }
}
