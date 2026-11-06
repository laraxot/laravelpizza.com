<?php

declare(strict_types=1);

namespace Modules\Seo\Datas;

use Modules\Seo\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Seo del tenant corrente: `config/{tenant}/seo.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin). Si legge con `SeoConfigData::make()` e non con
 * `config('seo.config.…')`: il config del modulo sostituisce quel ramo e un valore del tenant non arriverebbe.
 *
 * Una sola impostazione ha un lettore vivo: gli alias di pagina (middleware `RedirectToCanonicalPath` e sitemap).
 * Titolo e descrizione del sito stanno nel file `metatag` (Tenant, `MetatagData`) e l'indicizzazione del `<head>` e'
 * di Cms (`ResolveRobotsPolicyAction`): non si duplicano qui.
 *
 * @see SettingPage
 */
class SeoConfigData extends Data
{
    use MakesFromTenantConfig;

    /**
     * Pagine doppie del sito: percorso senza lingua dell'alias => percorso senza lingua della pagina canonica ('' = home).
     * Le righe sono una lista (non una mappa) perche' `SaveTenantConfigAction` fonde le mappe per chiave e un alias tolto
     * dal form tornerebbe nel file; una lista invece sostituisce lo stato intero.
     * `RedirectToCanonicalPath` risponde 301 nella stessa lingua e `BuildSitemapAction` non elenca l'alias. La destinazione
     * deve essere la pagina finale: gli alias che fanno giri o catene si ignorano (vedi `pathAliases()`).
     * Per ritirare un alias basta togliere la riga: la pagina torna a rispondere 200.
     * Scelta: la pagina con il contenuto completo in tutte le lingue attive (it, en) e con i link in ingresso.
     *
     * @var list<array{alias: string, target: string}>
     */
    public array $path_aliases = [
        [
            'alias' => 'about',
            'target' => 'chi-siamo',
        ],
        [
            'alias' => 'contatti',
            'target' => 'contacts',
        ],
        [
            'alias' => 'cookie',
            'target' => 'cookies',
        ],
        [
            'alias' => 'faqs',
            'target' => 'faq',
        ],
        [
            'alias' => 'home',
            'target' => '',
        ],
    ];

    /**
     * Un file scritto a mano o un form con righe incomplete non devono rompere ogni richiesta (il redirect e' un middleware
     * globale): valori che non sono una lista di righe testo/testo tornano al default, le righe sbagliate si scartano e
     * le chiavi delle righe del form (uuid) non si conservano.
     *
     * @param  array<string, mixed>  $properties
     * @return array<string, mixed>
     */
    public static function prepareForPipeline(array $properties): array
    {
        if (! array_key_exists('path_aliases', $properties)) {
            return $properties;
        }

        $rows = $properties['path_aliases'];
        unset($properties['path_aliases']);
        if (! is_array($rows)) {
            return $properties;
        }

        $clean = [];
        foreach ($rows as $row) {
            // Il campo `target` vuoto (home) arriva dal form come null.
            $target = is_array($row) ? ($row['target'] ?? '') : null;
            if (is_array($row) && is_string($row['alias'] ?? null) && is_string($target)) {
                $clean[] = [
                    'alias' => $row['alias'],
                    'target' => $target,
                ];
            }
        }
        $properties['path_aliases'] = $clean;

        return $properties;
    }

    /**
     * Mappa `alias => canonico` che usano middleware e sitemap, senza le righe che farebbero un giro di redirect:
     * alias vuoto, alias di se stesso, canonico che e' a sua volta un alias, alias ripetuto (vale l'ultimo).
     *
     * @return array<string, string>
     */
    public function pathAliases(): array
    {
        $map = [];
        foreach ($this->path_aliases as $row) {
            $alias = trim($row['alias'], '/');
            if ($alias !== '') {
                $map[$alias] = trim($row['target'], '/');
            }
        }

        return array_filter(
            $map,
            static fn (string $target, string $alias): bool => $target !== $alias && ! array_key_exists($target, $map),
            ARRAY_FILTER_USE_BOTH,
        );
    }

    /** `true` se almeno una riga non e' diventata un alias attivo: il form lo segnala invece di salvare in silenzio. */
    public function hasRejectedAliases(): bool
    {
        return count($this->pathAliases()) !== count($this->path_aliases);
    }
}
