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
 * Google le tratta come contenuto da verificare.
 */
final class BuildHeadSchemaAction
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $page  entità di pagina già risolta (vedi BuildPageSchemaAction)
     * @param  string|null  $rootUrl  URL della radice del sito, senza lingua: è l'identità dell'entità (`#organization`, `#website`); se manca si usa `$homeUrl`
     * @param  string  $homeLabel  nome della prima briciola («Home»); se vuoto si usa il brand
     * @param  list<string>|null  $languages  lingue in cui il sito è scritto; se manca si usa `$locale`
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
    ): array {
        $root = rtrim($rootUrl ?? $homeUrl, '/').'/';

        if ($isHome) {
            return [
                $this->organization($brand, $root, $logoUrl),
                $this->webSite($brand, $root, [] !== ($languages ?? []) ? (array) $languages : [$locale]),
            ];
        }

        return [
            $page === [] ? $page : $page + ['isPartOf' => ['@id' => $root.'#website']],
            $this->breadcrumbs($homeLabel !== '' ? $homeLabel : $brand, $homeUrl, $pageTitle, $pageUrl),
        ];
    }

    private function organization(string $brand, string $root, ?string $logoUrl): Organization
    {
        $organization = (new Organization)->name($brand)->url($root)->set('@id', $root.'#organization');

        return $logoUrl !== null ? $organization->logo($logoUrl) : $organization;
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
