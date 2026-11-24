<?php

declare(strict_types=1);

use Illuminate\Support\Arr;

/*
 * Un sync dei moduli porta indietro anche file SENZA conflitto, e NoMergeConflictMarkersTest non li vede.
 * Il 24/11/2026, nel solo tema Meetup: 92 file riportati a versioni vecchie, 10 file di public/ cancellati (font
 * inclusi) e 34 asset vecchi rimessi, 2 script npm cancellati ma ancora dichiarati in package.json, componenti Blade
 * e chiavi di traduzione spariti sotto viste che li usano. Questi controlli sono puri sul filesystem (tests/Unit non
 * avvia l'applicazione) e dicono quale file e' incoerente.
 *
 * @see Modules/Xot/docs/lessons/module-sync-merge-conflicts.md sezione «Regressioni silenziose»: analisi, numeri e rimedio
<<<<<<< .merge_file_uyoaAh
 * @see bashscripts/docs/operations/sync-repair-tools.md come trovare e riparare questi danni
=======
 * @see bashscripts/docs/sync-repair-tools.md come trovare e riparare questi danni
>>>>>>> .merge_file_8m4RCi
 */

/**
 * @see Modules/Xot/docs/lessons/module-sync-merge-conflicts.md perche' i controlli guardano solo i temi con un package.json
 *
 * @return list<string> Cartelle dei temi che hanno un proprio package.json.
 */
function themesWithPackageJson(): array
{
    $themes = glob(dirname(__DIR__, 5).'/Themes/*', GLOB_ONLYDIR) ?: [];

    return array_values(array_filter($themes, static fn (string $dir): bool => is_file($dir.'/package.json')));
}

test('every node script declared in the theme package.json exists', function (): void {
    foreach (themesWithPackageJson() as $theme) {
        $package = json_decode((string) file_get_contents($theme.'/package.json'), true, 512, JSON_THROW_ON_ERROR);
        $scripts = is_array($package['scripts'] ?? null) ? $package['scripts'] : [];

        foreach ($scripts as $name => $command) {
            if (is_string($command) && preg_match('/\bnode\s+(\S+)/', $command, $m) === 1) {
                expect(is_file($theme.'/'.$m[1]))->toBeTrue(basename($theme)." npm run {$name}: manca {$m[1]}");
            }
        }
    }
});

test('the vite manifest matches the compiled files: nothing missing, nothing stale', function (): void {
    foreach (themesWithPackageJson() as $theme) {
        if (! is_file($theme.'/public/manifest.json')) {
            continue;
        }
        $manifest = json_decode((string) file_get_contents($theme.'/public/manifest.json'), true, 512, JSON_THROW_ON_ERROR);

        $used = [];
        foreach ($manifest as $entry) {
            foreach ([$entry['file'] ?? null, ...($entry['css'] ?? []), ...($entry['assets'] ?? [])] as $file) {
                if (is_string($file)) {
                    $used[] = $file;
                }
            }
        }
        $missing = array_values(array_filter($used, static fn (string $file): bool => ! is_file($theme.'/public/'.$file)));
        $onDisk = array_map(static fn (string $path): string => 'assets/'.basename($path), glob($theme.'/public/assets/*') ?: []);

        // Stessa invariante di scripts/clean-stale-assets.mjs: public/assets contiene solo quello che il manifest usa.
        expect($missing)->toBe([], basename($theme).': file nel manifest ma non su disco (font, css, js)')
            ->and(array_values(array_diff($onDisk, $used)))->toBe([], basename($theme).': asset vecchi non usati dal manifest (npm run build li toglie)');
    }
});

test('every literal pub_theme translation key used by the theme views exists in the it and en lang files', function (): void {
    foreach (themesWithPackageJson() as $theme) {
        $langs = [];
        foreach (['it', 'en'] as $locale) {
            foreach (glob($theme."/lang/{$locale}/*.php") ?: [] as $file) {
                $langs[$locale][basename($file, '.php')] = (array) include $file;
            }
        }
        $missing = [];

        $views = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme.'/resources/views', FilesystemIterator::SKIP_DOTS));
        foreach ($views as $view) {
            if (! str_ends_with((string) $view, '.blade.php')) {
                continue;
            }
            // Solo chiamate di traduzione: 'pub_theme::components.ui.hero' (nome di vista) non e' una chiave.
            preg_match_all('/(?:__|trans|trans_choice|@lang)\(\s*[\'"]pub_theme::([a-z0-9_]+)\.([A-Za-z0-9_.\-]+)[\'"]/', (string) file_get_contents((string) $view), $found, PREG_SET_ORDER);
            foreach ($found as [, $file, $key]) {
                foreach (['it', 'en'] as $locale) {
                    if (! Arr::has($langs[$locale][$file] ?? [], rtrim($key, '.'))) {
                        $missing["{$locale}/{$file}.{$key}"] = str_replace($theme.'/resources/views/', '', (string) $view);
                    }
                }
            }
        }

        expect($missing)->toBe([], basename($theme).": chiavi usate dalle viste e assenti dai lang:\n".json_encode($missing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
});
