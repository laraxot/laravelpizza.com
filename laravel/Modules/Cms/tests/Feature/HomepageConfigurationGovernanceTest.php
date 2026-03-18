<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

test('there is exactly one canonical home page slug in json content', function (): void {
    $pagesPath = base_path('config/local/predict/database/content/pages');
    $files = glob($pagesPath.'/*.json');

    expect($files)->not->toBeFalse();

    $homeSlugFiles = collect($files ?: [])
        ->filter(function (string $file): bool {
            $data = json_decode((string) file_get_contents($file), true);

            return is_array($data) && ($data['slug'] ?? null) === 'home';
        })
        ->values();

    expect($homeSlugFiles)->toHaveCount(1);
    expect($homeSlugFiles->first())->toBe($pagesPath.'/1.json');
});

test('italian header navigation uses mercati label', function (): void {
    /** @var array<string, string> $translations */
    $translations = require base_path('Themes/TwentyOne/lang/it/headernav.php');
    /** @var array<string, string> $resourceTranslations */
    $resourceTranslations = require base_path('Themes/TwentyOne/resources/lang/it/headernav.php');

    expect($translations['markets'] ?? null)->toBe('Mercati');
    expect($resourceTranslations['markets'] ?? null)->toBe('Mercati');
});

test('canonical homepage starts with a clear hero and contains onboarding blocks', function (): void {
    $homepage = json_decode(
        (string) file_get_contents(base_path('config/local/predict/database/content/pages/1.json')),
        true,
    );

    expect($homepage)->toBeArray();

    /** @var array<int, array{type:string,data:array<string,mixed>}> $blocks */
    $blocks = $homepage['content_blocks']['it'] ?? [];

    expect($blocks[0]['type'] ?? null)->toBe('hero');
    expect($blocks[1]['type'] ?? null)->toBe('features');
    expect(collect($blocks)->pluck('type'))->toContain('widget', 'cta');
});

test('cms sections use unique slugs in json content', function (): void {
    $sectionsPath = base_path('config/local/predict/database/content/sections');
    $files = glob($sectionsPath.'/*.json');

    expect($files)->not->toBeFalse();

    $duplicates = collect($files ?: [])
        ->map(static function (string $file): array {
            $data = json_decode((string) file_get_contents($file), true);

            return [
                'file' => basename($file),
                'slug' => is_array($data) ? ($data['slug'] ?? null) : null,
            ];
        })
        ->filter(static fn (array $item): bool => is_string($item['slug']))
        ->groupBy('slug')
        ->filter(static fn ($group) => $group->count() > 1);

    expect($duplicates->all())->toBe([]);
});
