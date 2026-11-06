<?php

declare(strict_types=1);

use Modules\Xot\Tests\TestCase;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;
use function Safe\preg_match_all;

uses(TestCase::class);

/*
 * Proprieta' della sitemap (DCP-273): chi costruisce la sitemap e' Seo, e Seo non conosce chi gli fornisce gli URL.
 * Gli errori che questo test impedisce, entrambi gia' commessi: la classe che costruisce la sitemap messa in Fixcity (DCP-272),
 * e la sitemap di Seo che importa i modelli di Blog per elencare gli articoli (bozza della sessione parallela, DCP-273).
 * Un modulo che ha URL di dettaglio implementa `Seo\Contracts\SitemapPathsContract` e si registra con il tag
 * `SitemapPathsContract::TAG` nel proprio provider. Doc: Modules/Seo/docs/bmad/architecture-sitemap-ownership.md.
 */

/** Moduli che Seo puo' importare; allungare la lista e' una decisione di architettura, non una comodita'. */
const SEO_ALLOWED_MODULES = ['Seo', 'Xot', 'Cms'];

it('builds the sitemap only inside the Seo module', function (): void {
    $roots = [];
    foreach (glob(base_path('Modules/*/app')) as $root) {
        if (is_string($root)) {
            $roots[] = $root;
        }
    }

    $strangers = [];
    foreach (Finder::create()->files()->name('*.php')->in($roots) as $file) {
        $path = $file->getRealPath();
        if (str_starts_with($path, base_path('Modules/Seo/'))) {
            continue;
        }
        if (preg_match('/Spatie\\\\Sitemap|class\s+BuildSitemapAction\b/', file_get_contents($path)) === 1) {
            $strangers[] = substr($path, strlen(base_path()) + 1);
        }
    }

    expect($strangers)->toBe([]);
});

it('keeps Seo independent of the modules that feed its sitemap', function (): void {
    $offenders = [];
    foreach (Finder::create()->files()->name('*.php')->in(base_path('Modules/Seo/app')) as $file) {
        preg_match_all('/^use Modules\\\\([A-Za-z]+)\\\\/m', file_get_contents($file->getRealPath()), $found);
        foreach (array_unique($found[1]) as $module) {
            if (! in_array($module, SEO_ALLOWED_MODULES, true)) {
                $offenders[] = $file->getRelativePathname().' importa Modules\\'.$module;
            }
        }
    }

    expect($offenders)->toBe([]);
});
