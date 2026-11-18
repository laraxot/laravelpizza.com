<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Laravel\Head\Schema\SchemaObject;
use Modules\Cms\Actions\Head\BuildHeadSchemaAction;
use PHPUnit\Framework\Assert;

/**
 * @param  SchemaObject|array<string, mixed>  $schema
 * @return array<string, mixed>
 */
function schemaArray(SchemaObject|array $schema): array
{
    return $schema instanceof SchemaObject ? $schema->toArray() : $schema;
}

/**
 * @param  SchemaObject|array<string, mixed>  $schema
 * @return list<array<mixed>>
 */
function breadcrumbItems(SchemaObject|array $schema): array
{
    $items = schemaArray($schema)['itemListElement'] ?? [];
    Assert::assertIsArray($items);

    $list = [];
    foreach ($items as $item) {
        Assert::assertIsArray($item);
        $list[] = $item;
    }

    return $list;
}

test('home identity does not depend on the language of the page that publishes it', function (string $locale, string $homeUrl): void {
    $schemas = (new BuildHeadSchemaAction)->execute(
        isHome: true,
        brand: 'Example',
        homeUrl: $homeUrl,
        pageTitle: 'Example',
        pageUrl: $homeUrl,
        locale: $locale,
        logoUrl: 'https://example.test/logo.svg',
        page: [],
        rootUrl: 'https://example.test',
        languages: ['it', 'en'],
    );

    $organization = schemaArray($schemas[0]);
    $webSite = schemaArray($schemas[1]);

    Assert::assertSame('https://example.test/#organization', $organization['@id']);
    Assert::assertSame('https://example.test/', $organization['url']);
    Assert::assertSame('https://example.test/logo.svg', $organization['logo']);
    Assert::assertSame('https://example.test/#website', $webSite['@id']);
    Assert::assertSame(['it', 'en'], $webSite['inLanguage']);
})->with([
    'italian home' => ['it', 'https://example.test/it'],
    'english home' => ['en', 'https://example.test/en'],
]);

test('a site written in one language declares that language as a single value', function (): void {
    $schemas = (new BuildHeadSchemaAction)->execute(
        isHome: true,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Example',
        pageUrl: 'https://example.test/it',
        locale: 'it',
        logoUrl: null,
        page: [],
    );

    Assert::assertSame('it', schemaArray($schemas[1])['inLanguage']);
    Assert::assertArrayNotHasKey('logo', schemaArray($schemas[0]));
});

test('inner pages link to the web site and use short breadcrumb names', function (): void {
    $schemas = (new BuildHeadSchemaAction)->execute(
        isHome: false,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Domande Frequenti',
        pageUrl: 'https://example.test/it/faq',
        locale: 'it',
        logoUrl: null,
        page: ['@type' => 'WebPage', 'name' => 'Domande Frequenti'],
        rootUrl: 'https://example.test',
        homeLabel: 'Home',
    );

    $page = schemaArray($schemas[0]);
    $items = breadcrumbItems($schemas[1]);

    Assert::assertSame(['@id' => 'https://example.test/#website'], $page['isPartOf']);
    Assert::assertSame(['Home', 'Domande Frequenti'], array_column($items, 'name'));
    Assert::assertSame(['https://example.test/it', 'https://example.test/it/faq'], array_column($items, 'item'));
});

test('the first breadcrumb falls back to the brand and an existing isPartOf is kept', function (): void {
    $schemas = (new BuildHeadSchemaAction)->execute(
        isHome: false,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Servizi',
        pageUrl: 'https://example.test/it/servizi',
        locale: 'it',
        logoUrl: null,
        page: ['@type' => 'WebPage', 'isPartOf' => ['@id' => 'https://other.test/#website']],
    );

    Assert::assertSame('Example', breadcrumbItems($schemas[1])[0]['name']);
    Assert::assertSame(['@id' => 'https://other.test/#website'], schemaArray($schemas[0])['isPartOf']);
});
