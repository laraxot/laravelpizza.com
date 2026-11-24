<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Laravel\Head\Schema\SchemaObject;
use Modules\Cms\Actions\Head\BuildHeadSchemaAction;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

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

test('business data turn the home organization into a local business', function (): void {
<<<<<<< .merge_file_TT6oSY
<<<<<<< .merge_file_8r5c3N
<<<<<<< .merge_file_uU26I1
<<<<<<< .merge_file_uEV8l1
    $schemas = (new BuildHeadSchemaAction)->execute(
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_cUJJLs
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_Dz3A7T
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_B8nXsw
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_7pHd8h
        isHome: true,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Example',
        pageUrl: 'https://example.test/it',
        locale: 'it',
        logoUrl: 'https://example.test/logo.svg',
        page: [],
        rootUrl: 'https://example.test',
        business: [
            'type' => 'ProfessionalService',
            'name' => 'Ignored',
            'telephone' => '+39 041 000000',
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Mogliano Veneto', 'postalCode' => '31021'],
            'areaServed' => [['@type' => 'AdministrativeArea', 'name' => 'Veneto']],
            'email' => '',
            'sameAs' => [],
        ],
    );

    $organization = schemaArray($schemas[0]);

    Assert::assertSame('ProfessionalService', $organization['@type']);
    // Nome, URL e identità restano quelli del sito, anche se i dati dell'attività provano a cambiarli.
    Assert::assertSame('Example', $organization['name']);
    Assert::assertSame('https://example.test/#organization', $organization['@id']);
    Assert::assertSame('+39 041 000000', $organization['telephone']);
    $address = $organization['address'] ?? null;
    Assert::assertIsArray($address);
    Assert::assertSame('Mogliano Veneto', $address['addressLocality'] ?? null);
    Assert::assertSame('https://example.test/logo.svg', $organization['image']);
    // I valori vuoti non entrano: il validatore di laravel/head li rifiuta.
    Assert::assertArrayNotHasKey('email', $organization);
    Assert::assertArrayNotHasKey('sameAs', $organization);
});

test('without business data the home organization stays a plain Organization', function (): void {
<<<<<<< .merge_file_TT6oSY
<<<<<<< .merge_file_8r5c3N
<<<<<<< .merge_file_uU26I1
<<<<<<< .merge_file_uEV8l1
    $schemas = (new BuildHeadSchemaAction)->execute(
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_cUJJLs
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_Dz3A7T
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_B8nXsw
=======
    $schemas = (new BuildHeadSchemaAction())->execute(
>>>>>>> .merge_file_7pHd8h
        isHome: true,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Example',
        pageUrl: 'https://example.test/it',
        locale: 'it',
        logoUrl: null,
        page: [],
        rootUrl: 'https://example.test',
    );

    $organization = schemaArray($schemas[0]);

    Assert::assertSame('Organization', $organization['@type']);
    Assert::assertArrayNotHasKey('address', $organization);
});

/**
 * @param  list<string>  $sameAs
 * @return array<string, mixed>
 */
function homeOrganization(?string $description, array $sameAs): array
{
    return schemaArray((new BuildHeadSchemaAction)->execute(
        isHome: true,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Example',
        pageUrl: 'https://example.test/it',
        locale: 'it',
        logoUrl: null,
        page: [],
        rootUrl: 'https://example.test',
        description: $description,
        sameAs: $sameAs,
    )[0]);
}

test('home organization carries description and official profiles only when the tenant has them', function (): void {
    $full = homeOrganization('  Segnala un disservizio al Comune.  ', ['https://www.linkedin.com/company/example', 'https://github.com/example']);
    Assert::assertSame('Segnala un disservizio al Comune.', $full['description']);
    Assert::assertSame(['https://www.linkedin.com/company/example', 'https://github.com/example'], $full['sameAs']);

    $bare = homeOrganization(' ', []);
    Assert::assertArrayNotHasKey('description', $bare);
    Assert::assertArrayNotHasKey('sameAs', $bare);
});

test('business data and site description combine, and business wins on the same property', function (): void {
    $organization = schemaArray((new BuildHeadSchemaAction)->execute(
        isHome: true,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Example',
        pageUrl: 'https://example.test/it',
        locale: 'it',
        logoUrl: null,
        page: [],
        rootUrl: 'https://example.test',
        business: ['type' => 'ProfessionalService', 'sameAs' => ['https://business.example/profile']],
        description: 'Descrizione del sito',
        sameAs: ['https://www.linkedin.com/company/example'],
    )[0]);

    Assert::assertSame('ProfessionalService', $organization['@type']);
    Assert::assertSame('Descrizione del sito', $organization['description']);
    Assert::assertSame(['https://business.example/profile'], $organization['sameAs']);
});
