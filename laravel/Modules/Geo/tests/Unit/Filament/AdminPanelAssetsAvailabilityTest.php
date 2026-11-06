<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

use Illuminate\Support\Facades\File;
use Modules\Geo\Providers\Filament\AdminPanelProvider;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

/*
 * Regressione: senza `public_html/assets/geo/manifest.json` tutti i pannelli Filament rispondevano 500
 * (ViteManifestNotFoundException), anche in produzione. Il provider deve rilevare la build mancante.
 *
 * Il test lavora solo in una cartella temporanea passata come radice pubblica: `App\Application::publicPath()`
 * ignora `usePublicPath()` e scrivere in `public_html` romperebbe gli asset reali (manifest finto, file `hot`).
 */
function geoPanelTempPublicRoot(): string
{
    $root = sys_get_temp_dir().'/geo-panel-assets-'.uniqid();
    File::ensureDirectoryExists($root);

    return $root;
}

it('returns false when neither the Vite build nor the hot file exist', function (): void {
    $root = geoPanelTempPublicRoot();

    try {
        Assert::assertFalse(AdminPanelProvider::assetsAreAvailable($root));
    } finally {
        File::deleteDirectory($root);
    }
});

it('returns true when the Vite manifest exists', function (): void {
    $root = geoPanelTempPublicRoot();

    try {
        File::ensureDirectoryExists($root.'/'.AdminPanelProvider::BUILD_DIRECTORY);
        File::put($root.'/'.AdminPanelProvider::BUILD_DIRECTORY.'/manifest.json', '{}');

        Assert::assertTrue(AdminPanelProvider::assetsAreAvailable($root));
    } finally {
        File::deleteDirectory($root);
    }
});

it('returns true when the Vite dev server hot file exists', function (): void {
    $root = geoPanelTempPublicRoot();

    try {
        File::put($root.'/hot', 'http://localhost:5173');

        Assert::assertTrue(AdminPanelProvider::assetsAreAvailable($root));
    } finally {
        File::deleteDirectory($root);
    }
});
