<?php

declare(strict_types=1);

namespace Modules\Cms\Actions\Head;

use Laravel\Head\Schema\Breadcrumbs;
use Laravel\Head\Schema\Organization;
use Laravel\Head\Schema\SchemaObject;
use Laravel\Head\Schema\WebSite;
use Spatie\QueueableAction\QueueableAction;

/**
 * Dati strutturati schema.org del `<head>`.
 *
 * Home: `Organization` + `WebSite` (descrivono chi è il sito, una volta sola), con un `@id` che non dipende dalla lingua:
 * `/it` e `/en` descrivono la stessa entità. Pagine interne: l'entità di pagina già risolta (che rimanda al `WebSite` con
 * `isPartOf`) + `BreadcrumbList` con nomi brevi.
 * Non si pubblicano proprietà senza dato reale (indirizzo, telefono, sameAs):
 * Google le tratta come contenuto da verificare. `description` e `sameAs` entrano solo se il tenant li ha (descrizione del
 * sito, profili ufficiali in `metatag`): sono i segnali con cui un motore lega il nome del sito a un'entità.
 *
 * @see Modules/Seo/docs/adr/search-engine-presence.md
 */
final class BuildHeadSchemaAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $page  entità di pagina già risolta (vedi BuildPageSchemaAction)
     * @param  string|null  $rootUrl  URL della radice del sito, senza lingua: è l'identità dell'entità (`#organization`, `#website`); se manca si usa `$homeUrl`
     * @param  string  $homeLabel  nome della prima briciola («Home»); se vuoto si usa il brand
     * @param  list<string>|null  $languages  lingue in cui il sito è scritto; se manca si usa `$locale`
     * @param  string|null  $description  descrizione dell'organizzazione (home); vuota = proprietà assente
     * @param  list<string>  $sameAs  profili ufficiali (URL https), già filtrati; [] = proprietà assente
     * @return list<SchemaObject|array<string, mixed>>
     */
    public function execute(
        bool $isHome,
        string $brand,
        string $homeUrl,
        string $pageTitle,
        string $pageUrl,
        string $locale,
        ?string $logoUrl,
        array $page,
        ?string $rootUrl = null,
        string $homeLabel = '',
        ?array $languages = null,
        ?string $description = null,
        array $sameAs = [],
    ): array {
        $root = rtrim($rootUrl ?? $homeUrl, '/').'/';

        if ($isHome) {
            return [
                $this->organization($brand, $root, $logoUrl, $description, $sameAs),
                $this->webSite($brand, $root, [] !== ($languages ?? []) ? (array) $languages : [$locale]),
            ];
        }

        return [
            $page === [] ? $page : $page + ['isPartOf' => ['@id' => $root.'#website']],
            $this->breadcrumbs($homeLabel !== '' ? $homeLabel : $brand, $homeUrl, $pageTitle, $pageUrl),
        ];
    }

    /**
     * @param  list<string>  $sameAs
     */
    private function organization(string $brand, string $root, ?string $logoUrl, ?string $description, array $sameAs): Organization
    {
        $organization = (new Organization)->name($brand)->url($root)->set('@id', $root.'#organization');
        if ($logoUrl !== null) {
            $organization = $organization->logo($logoUrl);
        }
        if ($description !== null && trim($description) !== '') {
            $organization = $organization->set('description', trim($description));
        }

        return $sameAs !== [] ? $organization->set('sameAs', array_values($sameAs)) : $organization;
    }

    /**
     * @param  list<string>  $languages
     */
    private function webSite(string $brand, string $root, array $languages): SchemaObject
    {
        return (new WebSite)->name($brand)->url($root)->set('@id', $root.'#website')
            ->set('inLanguage', count($languages) === 1 ? $languages[0] : $languages);
    }

    private function breadcrumbs(string $homeLabel, string $homeUrl, string $pageTitle, string $pageUrl): Breadcrumbs
    {
        return (new Breadcrumbs)->item($homeLabel, $homeUrl)->item($pageTitle, $pageUrl);
    }
}
