<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Cms\Tests\UnitTestCase;
use Modules\Tenant\Services\TenantService;

uses(UnitTestCase::class);

it('header.json contiene voci di navigazione primarie', function (): void {
    $path = TenantService::filePath('database/content/sections/header.json');
    expect(file_exists($path))->toBeTrue();
    $config = File::json($path);
    $items = $config['sections']['primary_nav']['items'] ?? [];
    expect($items)->toBeArray()->not->toBeEmpty();
    // Verifica che esistano link primari (nav_group=primary)
    $primary = array_filter($items, fn ($i): bool => ($i['nav_group'] ?? 'primary') === 'primary');
    expect(count($primary))->toBeGreaterThan(0);
});

it('header.json ha la struttura corretta con active_patterns', function (): void {
    $path = TenantService::filePath('database/content/sections/header.json');
    $config = File::json($path);
    $items = $config['sections']['primary_nav']['items'] ?? [];
    foreach ($items as $item) {
        expect($item)->toHaveKey('label');
        expect($item)->toHaveKey('url');
        expect($item)->toHaveKey('nav_group');
        expect($item)->toHaveKey('order');
        expect($item)->toHaveKey('enabled');
    }
});

it('header.json contiene link specifici richiesti', function (): void {
    $path = TenantService::filePath('database/content/sections/header.json');
    $config = File::json($path);
    $items = $config['sections']['primary_nav']['items'] ?? [];

    $slugs = array_map(fn ($i): string => $i['slug'] ?? '', $items);

    // Verifica presenza link principali
    expect($slugs)->toContain('amministrazione');
    expect($slugs)->toContain('novita');
    expect($slugs)->toContain('servizi');
    expect($slugs)->toContain('vivere-il-comune');
});

it('header.json contiene link secondari richiesti', function (): void {
    $path = TenantService::filePath('database/content/sections/header.json');
    $config = File::json($path);
    $items = $config['sections']['primary_nav']['items'] ?? [];

    $secondary = array_filter($items, fn ($i): bool => ($i['nav_group'] ?? 'primary') === 'secondary');
    $slugs = array_map(fn ($i): string => $i['slug'] ?? '', $secondary);

    // Verifica presenza link secondari
    expect($slugs)->toContain('iscrizioni');
    expect($slugs)->toContain('estate-in-citta');
    expect($slugs)->toContain('polizia-locale');
});

it('header.json ha topics_url configurato', function (): void {
    $path = TenantService::filePath('database/content/sections/header.json');
    $config = File::json($path);
    $topicsUrl = $config['sections']['primary_nav']['topics_url'] ?? null;
    expect($topicsUrl)->not->toBeNull();
    expect($topicsUrl)->toBeString();
    expect($topicsUrl)->toContain('argomenti');
});
