<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

/**
 * @return array<string, mixed>
 */
function headerNavConfig(): array
{
    $path = app(GetTenantFilePathAction::class)->execute('database/content/sections/header.json');
    if (! file_exists($path)) {
        cmsSkipTest('header.json not found in this install: '.$path);
    }

    $decoded = File::json($path);
    if (! is_array($decoded)) {
        cmsSkipTest('header.json is not a valid JSON object: '.$path);
    }

    /** @var array<string, mixed> $config */
    $config = $decoded;

    return $config;
}

/**
 * @param  array<string, mixed>  $config
 * @return list<array<string, mixed>>
 */
function primaryNavItems(array $config): array
{
    $sections = $config['sections'] ?? null;
    if (! is_array($sections)) {
        return [];
    }

    $primaryNav = $sections['primary_nav'] ?? null;
    if (! is_array($primaryNav)) {
        return [];
    }

    $items = $primaryNav['items'] ?? null;
    if (! is_array($items)) {
        return [];
    }

    /** @var list<array<string, mixed>> $normalized */
    $normalized = array_values(array_filter($items, static fn (mixed $item): bool => is_array($item)));

    return $normalized;
}

/**
 * @param  list<array<string, mixed>>  $items
 * @return list<string>
 */
function navItemSlugs(array $items): array
{
    return array_map(static function (array $item): string {
        $slug = $item['slug'] ?? '';

        return is_string($slug) ? $slug : '';
    }, $items);
}

describe('Header Nav Json', function (): void {
    test('header json contiene voci di navigazione primarie', function (): void {
        /** @var list<array<string, mixed>> $items */
        $items = primaryNavItems(headerNavConfig());

        $primary = array_values(array_filter(
            $items,
            static fn (array $item): bool => ($item['nav_group'] ?? 'primary') === 'primary',
        ));
        Assert::assertGreaterThan(0, count($primary));
    });

    test('header json ha la struttura corretta con active patterns', function (): void {
        $config = headerNavConfig();
        $items = primaryNavItems($config);
        foreach ($items as $item) {
            Assert::assertArrayHasKey('label', $item);
            Assert::assertArrayHasKey('url', $item);
            Assert::assertArrayHasKey('nav_group', $item);
            Assert::assertArrayHasKey('order', $item);
            Assert::assertArrayHasKey('enabled', $item);
        }
    });

    test('header json contiene link specifici richiesti', function (): void {
        $slugs = navItemSlugs(primaryNavItems(headerNavConfig()));

        Assert::assertContains('amministrazione', $slugs);
        Assert::assertContains('novita', $slugs);
        Assert::assertContains('servizi', $slugs);
        Assert::assertContains('vivere-il-comune', $slugs);
    });

    test('header json contiene link secondari richiesti', function (): void {
        /** @var list<array<string, mixed>> $items */
        $items = primaryNavItems(headerNavConfig());

        /** @var list<array<string, mixed>> $secondary */
        $secondary = array_values(array_filter(
            $items,
            static fn (array $item): bool => ($item['nav_group'] ?? 'primary') === 'secondary',
        ));
        $slugs = navItemSlugs($secondary);

        Assert::assertContains('iscrizioni', $slugs);
        Assert::assertContains('estate-in-citta', $slugs);
        Assert::assertContains('polizia-locale', $slugs);
    });

    test('header json ha topics url configurato', function (): void {
        $config = headerNavConfig();
        $sections = $config['sections'] ?? null;
        /** @var array<string, mixed> $sections */
        $primaryNav = $sections['primary_nav'] ?? null;
        /** @var array<string, mixed> $primaryNav */
        $topicsUrl = $primaryNav['topics_url'] ?? null;
        Assert::assertNotNull($topicsUrl);
        Assert::assertStringContainsString('argomenti', SafeStringCastAction::cast($topicsUrl));
    });
});
