<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(Modules\Cms\Tests\TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\Cms\Tests\TestCase $this */
    cmsSkipTest('Homepage governance tests target predict JSON fixtures, not fixcity.');
});

test('there is exactly one canonical home page slug in json content', function (): void {
    $pagesPath = base_path('config/local/predict/database/content/pages');
    $globResult = glob($pagesPath.'/*.json');
    Assert::assertNotFalse($globResult);
    /** @var list<string> $files */
    $files = $globResult;

    Assert::assertNotEmpty($files);

    $homeSlugFiles = collect($files)
        ->filter(function (string $file): bool {
            $raw = cmsJsonDecodeFile($file);
            /** @var array<string, mixed> $data */
            $data = $raw;

            return ($data['slug'] ?? null) === 'home';
        })
        ->values();

    Assert::assertCount(1, $homeSlugFiles);
    Assert::assertSame($pagesPath.'/1.json', $homeSlugFiles->first());
});

test('italian header navigation uses mercati label', function (): void {
    /** @var array<string, string> $translations */
    $translations = require base_path('Themes/TwentyOne/lang/it/headernav.php');

    Assert::assertSame('Mercati', $translations['markets'] ?? null);
});

test('canonical homepage starts with a clear hero and contains onboarding blocks', function (): void {
    /** @var array<string, mixed> $homepage */
    $homepage = cmsJsonDecodeFile(base_path('config/local/predict/database/content/pages/1.json'));
    /** @var array<string, mixed> $contentBlocks */
    $contentBlocks = $homepage['content_blocks'] ?? [];
    /** @var array<int, array{type:string,data:array<string,mixed>}> $blocks */
    $blocks = $contentBlocks['it'] ?? [];

    Assert::assertSame('hero', $blocks[0]['type'] ?? null);
    Assert::assertSame('features', $blocks[1]['type'] ?? null);
    Assert::assertContains('widget', collect($blocks)->pluck('type')->all());
    Assert::assertContains('cta', collect($blocks)->pluck('type')->all());
});
