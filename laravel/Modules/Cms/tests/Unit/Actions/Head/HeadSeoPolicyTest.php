<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Modules\Cms\Actions\Head\BuildHeadSchemaAction;
use Modules\Cms\Actions\Head\ResolveHreflangAlternatesAction;
use Modules\Cms\Actions\Head\ResolveRobotsPolicyAction;
use Modules\Cms\Actions\BuildPageSchemaAction;
use Modules\Xot\Datas\MetatagData;
use Laravel\Head\Schema\SchemaObject;
use PHPUnit\Framework\Assert;

/**
 * @param SchemaObject|array<string, mixed> $schema
 */
function schemaType(SchemaObject|array $schema): ?string
{
    $data = $schema instanceof SchemaObject ? $schema->toArray() : $schema;
    $type = $data['@type'] ?? null;

    return is_string($type) ? $type : null;
}

test('robots policy hides private and untranslated pages', function (): void {
    $policy = new ResolveRobotsPolicyAction;
    $locales = ['it', 'en'];

    Assert::assertSame('noindex, follow', $policy->execute('it/auth/login', $locales));
    Assert::assertSame('noindex, follow', $policy->execute('it/servizi', $locales, false));
    Assert::assertSame('index, follow, max-image-preview:large', $policy->execute('it/servizi', $locales));
});

test('hreflang policy removes query fragments and adds the default locale', function (): void {
    $policy = new ResolveHreflangAlternatesAction;

    Assert::assertSame(
        [
            'it' => 'https://example.test/it/servizi',
            'en' => 'https://example.test/en/services',
            'x-default' => 'https://example.test/it/servizi',
        ],
        $policy->build([
            'it' => 'https://example.test/it/servizi?ref=nav#content',
            'en' => 'https://example.test/en/services#content',
        ], 'it'),
    );

    Assert::assertSame([], $policy->build(['it' => 'https://example.test/it/servizi'], 'it'));
});

test('head schema separates homepage identity from page breadcrumbs', function (): void {
    $builder = new BuildHeadSchemaAction;

    $home = $builder->execute(
        isHome: true,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Homepage',
        pageUrl: 'https://example.test/it',
        locale: 'it',
        logoUrl: null,
        page: [],
    );

    Assert::assertCount(2, $home);
    Assert::assertSame('Organization', schemaType($home[0]));
    Assert::assertSame('WebSite', schemaType($home[1]));

    $page = $builder->execute(
        isHome: false,
        brand: 'Example',
        homeUrl: 'https://example.test/it',
        pageTitle: 'Servizi',
        pageUrl: 'https://example.test/it/servizi',
        locale: 'it',
        logoUrl: null,
        page: ['@type' => 'WebPage', 'name' => 'Servizi'],
    );

    Assert::assertSame('WebPage', schemaType($page[0]));
    Assert::assertSame('BreadcrumbList', schemaType($page[1]));
});

test('page schema accepts the canonical URL rendered by the head component', function (): void {
    $schema = (new BuildPageSchemaAction)->execute(
        meta: MetatagData::make(),
        routeName: 'home',
        path: '/',
        canonical: 'https://example.test/it',
    );

    Assert::assertSame('https://example.test/it', $schema['url'] ?? null);
});
