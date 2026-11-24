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
<<<<<<< HEAD
=======
     * @param  array<string, mixed>  $business  dati dell'attività dal tenant (`metatag.business`): `type` (per esempio
     *                                          `ProfessionalService`, sottotipo di LocalBusiness) e proprietà schema.org
     *                                          (`telephone`, `email`, `address`, `areaServed`, `sameAs`, ...). Vuoto =
     *                                          Organization con solo nome, URL e logo.
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
=======
        array $business = [],
>>>>>>> laraxot/dev
        ?string $description = null,
        array $sameAs = [],
    ): array {
        $root = rtrim($rootUrl ?? $homeUrl, '/').'/';

        if ($isHome) {
            return [
<<<<<<< HEAD
                $this->organization($brand, $root, $logoUrl, $description, $sameAs),
=======
                $this->organization($brand, $root, $logoUrl, $business, $description, $sameAs),
>>>>>>> laraxot/dev
                $this->webSite($brand, $root, [] !== ($languages ?? []) ? (array) $languages : [$locale]),
            ];
        }

        return [
            $page === [] ? $page : $page + ['isPartOf' => ['@id' => $root.'#website']],
            $this->breadcrumbs($homeLabel !== '' ? $homeLabel : $brand, $homeUrl, $pageTitle, $pageUrl),
        ];
    }

    /**
<<<<<<< HEAD
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
=======
     * Con i dati dell'attività l'organizzazione diventa un'attività locale (indirizzo, telefono, zona servita): è
     * il segnale che Google usa per le ricerche «servizio + città». Nome, URL, `@id` e logo restano quelli del sito.
     * `description` e `sameAs` del sito entrano se l'attività non li dichiara già.
     *
     * @param  array<string, mixed>  $business
     * @param  list<string>  $sameAs
     */
    private function organization(string $brand, string $root, ?string $logoUrl, array $business = [], ?string $description = null, array $sameAs = []): Organization
    {
        $type = $business['type'] ?? null;
        $organization = (new Organization(is_string($type) && $type !== '' ? $type : null))
            ->name($brand)->url($root)->set('@id', $root.'#organization');

        if ($logoUrl !== null) {
            $organization = $organization->logo($logoUrl)->set('image', $logoUrl);
        }

        foreach ($business as $property => $value) {
            if (\in_array($property, ['type', 'name', 'url', '@id', '@type', 'logo'], true) || $this->isEmpty($value)) {
                continue;
            }
            $organization = $organization->set($property, $value);
        }

        if ($description !== null && trim($description) !== '' && $this->isEmpty($business['description'] ?? null)) {
            $organization = $organization->set('description', trim($description));
        }
        if ($sameAs !== [] && $this->isEmpty($business['sameAs'] ?? null)) {
            $organization = $organization->set('sameAs', array_values($sameAs));
        }

        return $organization;
    }

    /** Valori vuoti fuori: il validatore di laravel/head li rifiuta e uno schema con campi vuoti non serve. */
    private function isEmpty(mixed $value): bool
    {
        if (\is_array($value)) {
            return array_filter($value, fn (mixed $item): bool => ! $this->isEmpty($item)) === [];
        }

        return $value === null || (\is_string($value) && trim($value) === '');
>>>>>>> laraxot/dev
    }

    /**
     * @param  list<string>  $languages
     */
    private function webSite(string $brand, string $root, array $languages): SchemaObject
    {
<<<<<<< HEAD
        return (new WebSite)->name($brand)->url($root)->set('@id', $root.'#website')
=======
        return (new WebSite())->name($brand)->url($root)->set('@id', $root.'#website')
>>>>>>> laraxot/dev
            ->set('inLanguage', count($languages) === 1 ? $languages[0] : $languages);
    }

    private function breadcrumbs(string $homeLabel, string $homeUrl, string $pageTitle, string $pageUrl): Breadcrumbs
    {
<<<<<<< HEAD
        return (new Breadcrumbs)->item($homeLabel, $homeUrl)->item($pageTitle, $pageUrl);
=======
        return (new Breadcrumbs())->item($homeLabel, $homeUrl)->item($pageTitle, $pageUrl);
>>>>>>> laraxot/dev
    }
}
