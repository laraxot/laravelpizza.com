<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use Safe\Exceptions\JsonException;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\json_decode;
use function Safe\json_encode;

/*
 * Guardie DCP-101 sull'integrita' dei contenuti delle pagine di prova `/it/tests/<slug>` (pagina = JSON + blocchi del tema).
 * Solo filesystem, nessun database, nessun HTTP. Ogni guardia nasce da un incidente reale del 2026-10-13:
 *  (a) due JSON con lo stesso `slug` nella stessa cartella -> 500 "CMS content collision" per tutti;
 *  (b) copie tenant/modulo divergenti, o `id`/`slug` diversi dal nome file;
 *  (c) `npm run copy` azzera le immagini (file da 0 byte in design-comuni/assets);
 *  (d) il manifest design-comuni-pages.txt e i JSON `tests.*` devono corrispondersi;
 *  (e) un blocco Blade cancellato o rinominato rompe il test, non la pagina.
 * Criterio di identita' (b): JSON decodificato, ordine delle chiavi degli oggetti ignorato, ordine delle liste e tipi rispettati.
 * Vedi Modules/Cms/docs/stories/dcp-101-guardie-json-asset-manifest.story.md.
 */

function contentGuardRoot(): string
{
    return dirname(__DIR__, 5);
}

function contentGuardPublicTheme(): string
{
    $theme = function_exists('config') ? config('xot.pub_theme', 'Two') : 'Two';

    return is_string($theme) && $theme !== '' ? $theme : 'Two';
}

/** @return list<string> */
function contentGuardGlob(string $pattern, int $flags = 0): array
{
    return array_values(array_filter(glob($pattern, $flags), is_string(...)));
}

/** @return list<string> cartelle `content/pages` (tenant e moduli), relative a laravel/ */
function contentGuardPageDirs(): array
{
    $root = contentGuardRoot();
    $dirs = [...contentGuardGlob($root.'/config/*/*/database/content/pages', GLOB_ONLYDIR), ...contentGuardGlob($root.'/Modules/*/config/database/content/pages', GLOB_ONLYDIR)];

    return array_map(static fn (string $dir): string => substr($dir, strlen($root) + 1), $dirs);
}

/** @return array<string, array{string}> */
function contentGuardPageDirDataset(): array
{
    $dataset = [];
    foreach (contentGuardPageDirs() as $dir) {
        $dataset[$dir] = [$dir];
    }

    return $dataset;
}

/**
 * Coppie [cartella tenant, cartella modulo] dello stesso modulo: `config/<tenant>/<modulo>/...` e `Modules/<Modulo>/config/...`.
 *
 * @return array<string, array{string, string}>
 */
function contentGuardTenantModulePairs(): array
{
    $dirs = contentGuardPageDirs();
    $pairs = [];
    foreach ($dirs as $dir) {
        // Il filesystem è case-sensitive: il tenant può usare una variante
        // diversa dal nome PSR del modulo (techplanner/TechPlanner).
        if (str_starts_with($dir, 'config/')) {
            $tenantModule = basename(dirname($dir, 3));
            $moduleDir = null;
            foreach ($dirs as $candidate) {
                if (str_starts_with($candidate, 'Modules/')
                    && strcasecmp(basename(dirname($candidate, 4)), $tenantModule) === 0) {
                    $moduleDir = $candidate;
                    break;
                }
            }
            if (is_string($moduleDir)) {
                $pairs[$dir.' vs '.$moduleDir] = [$dir, $moduleDir];
            }
        }
    }

    return $pairs;
}

/** @return array<array-key, mixed> */
function contentGuardPage(string $relativePath): array
{
    try {
        $json = json_decode(file_get_contents(contentGuardRoot().'/'.$relativePath), true);
    } catch (JsonException $exception) {
        Assert::fail($relativePath.': JSON non valido ('.$exception->getMessage().')');
    }
    Assert::assertIsArray($json, $relativePath.': la radice del JSON deve essere un oggetto.');

    return $json;
}

/** @return array<string, array<array-key, mixed>> pagine della cartella, chiave = percorso relativo del file */
function contentGuardPagesIn(string $dir): array
{
    $pages = [];
    foreach (contentGuardGlob(contentGuardRoot().'/'.$dir.'/*.json') as $file) {
        $relative = $dir.'/'.basename($file);
        $pages[$relative] = contentGuardPage($relative);
    }

    return $pages;
}

/** Ordina ricorsivamente le chiavi degli oggetti (non delle liste): due JSON con le stesse chiavi in ordine diverso risultano uguali. */
function contentGuardSorted(mixed $node): mixed
{
    if (! is_array($node)) {
        return $node;
    }
    $node = array_map(contentGuardSorted(...), $node);
    if (! array_is_list($node)) {
        ksort($node, SORT_STRING);
    }

    return $node;
}

/**
 * @param  array<array-key, mixed>  $left
 * @param  array<array-key, mixed>  $right
 * @return list<string> chiavi di primo livello con valore diverso o presenti in una sola copia
 */
function contentGuardDifferingKeys(array $left, array $right): array
{
    $differing = [];
    foreach (array_unique([...array_keys($left), ...array_keys($right)]) as $key) {
        if (array_key_exists($key, $left) !== array_key_exists($key, $right) || contentGuardSorted($left[$key]) !== contentGuardSorted($right[$key])) {
            $differing[] = (string) $key;
        }
    }

    return $differing;
}

/** @return array<string, string> percorso JSON => nome di vista, per ogni chiave `view` stringa a qualsiasi profondita' */
function contentGuardViews(mixed $node, string $path): array
{
    if (! is_array($node)) {
        return [];
    }
    $found = [];
    foreach ($node as $key => $value) {
        $where = $path.'/'.$key;
        if ($key === 'view' && is_string($value)) {
            $found[$where] = $value;
        }
        $found += contentGuardViews($value, $where);
    }

    return $found;
}

/**
 * Riga del manifest -> slug: `<nome>.html` -> `<nome>`; `index.html` -> `index`; `<cartella>/index.html` -> `<cartella>-index`.
 *
 * @return array<string, string> slug => riga del manifest
 */
function contentGuardManifest(): array
{
    $rows = [];
    $manifest = contentGuardRoot().'/Themes/Sixteen/scripts/design-comuni-pages.txt';
    if (! is_file($manifest)) {
        return [];
    }

    foreach (explode("\n", file_get_contents($manifest)) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        $name = basename($line, '.html');
        $folder = dirname($line);
        $rows[$name !== 'index' ? $name : ($folder === '.' ? 'index' : str_replace('/', '-', $folder).'-index')] = $line;
    }

    return $rows;
}

/** @return array<string, string> slug => motivo: pagine `tests.*` del tenant volutamente senza riga nel manifest */
function contentGuardManifestExceptions(): array
{
    return [
        'catalog' => 'voci di catalogo verso le altre pagine di prova, non replica una pagina di riferimento (DCP-25, DCP-80)',
        'pagamenti-multa-pagamento' => 'derivata da servizi-pagamento-pagamento: il riferimento servizi/pagamenti-multa-pagamento.html risponde 404 (DCP-28)',
    ];
}

/** @param list<string> $problems */
function contentGuardAssertNone(array $problems, string $title): void
{
    Assert::assertSame([], $problems, $title."\n - ".implode("\n - ", $problems));
}

dataset('page directories', contentGuardPageDirDataset(...));
dataset('tenant and module page directories', contentGuardTenantModulePairs(...));

it('finds the TechPlanner tenant and module page folders', function (): void {
    $dirs = contentGuardPageDirs();

    Assert::assertContains('config/local/techplanner/database/content/pages', $dirs);
    Assert::assertContains('Modules/TechPlanner/config/database/content/pages', $dirs);
    Assert::assertNotEmpty(contentGuardTenantModulePairs());
});

// (a) incidente: homepage.json + tests.homepage.json con slug identico -> 500 "CMS content collision".
it('has no two page JSON files with the same slug in the same folder', function (string $dir): void {
    $bySlug = [];
    foreach (contentGuardPagesIn($dir) as $file => $page) {
        if (is_string($page['slug'] ?? null)) {
            $bySlug[$page['slug']][] = $file;
        }
    }
    $collisions = [];
    foreach ($bySlug as $slug => $files) {
        if (count($files) > 1) {
            $collisions[] = sprintf('slug [%s] dichiarato da %s', $slug, implode(' e ', $files));
        }
    }

    contentGuardAssertNone($collisions, 'CMS content collision (due file, stesso slug, stessa cartella):');
})->with('page directories');

// (b) il tenant vince sul modulo: le copie devono restare identiche.
it('keeps tests.*.json identical between tenant and module', function (string $tenantDir, string $moduleDir): void {
    $differences = [];
    foreach (contentGuardGlob(contentGuardRoot().'/'.$tenantDir.'/tests.*.json') as $file) {
        $name = basename($file);
        if (! is_file(contentGuardRoot().'/'.$moduleDir.'/'.$name)) {
            continue; // confronto solo se la copia esiste in entrambi
        }
        $keys = contentGuardDifferingKeys(contentGuardPage($tenantDir.'/'.$name), contentGuardPage($moduleDir.'/'.$name));
        if ($keys !== []) {
            $differences[] = sprintf('%s e %s differiscono (chiavi: %s)', $tenantDir.'/'.$name, $moduleDir.'/'.$name, implode(', ', $keys));
        }
    }

    contentGuardAssertNone($differences, 'Copie tenant/modulo non identiche (JSON decodificato, ordine delle chiavi ignorato):');
})->with('tenant and module page directories');

it('names every tests.*.json after its id and slug', function (string $dir): void {
    $wrong = [];
    foreach (contentGuardPagesIn($dir) as $file => $page) {
        $expected = basename($file, '.json');
        if (! str_starts_with($expected, 'tests.')) {
            continue;
        }
        foreach (['id', 'slug'] as $field) {
            if (($page[$field] ?? null) !== $expected) {
                $wrong[] = sprintf('%s: %s e [%s], atteso [%s]', $file, $field, json_encode($page[$field] ?? null), $expected);
            }
        }
    }

    contentGuardAssertNone($wrong, 'id e slug devono coincidere con il nome file:');
})->with('page directories');

// (c) incidente: `npm run copy` ha azzerato due PNG (sorgente vuota).
it('has no zero byte file under design-comuni assets', function (): void {
    $dir = contentGuardRoot().'/Themes/Sixteen/public/design-comuni/assets';
    if (! is_dir($dir)) {
        Assert::markTestSkipped('La guardia Design Comuni vale solo per il tema Sixteen, non attivo in questo progetto.');
    }
    $checked = 0;
    $empty = [];
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)) as $file) {
        if (! $file instanceof SplFileInfo || ! $file->isFile()) {
            continue;
        }
        $checked++;
        if ($file->getSize() === 0) {
            $empty[] = substr($file->getPathname(), strlen(contentGuardRoot()) + 1);
        }
    }

    Assert::assertGreaterThan(0, $checked, 'Nessun file sotto design-comuni/assets: la guardia non controllerebbe niente.');

    contentGuardAssertNone($empty, 'File da 0 byte (ripristinare dalla sorgente, non rilanciare `npm run copy` alla cieca):');
});

// (d) manifest design-comuni-pages.txt <-> JSON `tests.*` (tenant local/fixcity e modulo Fixcity).
it('has a tests JSON in tenant and module for every manifest row', function (): void {
    if (contentGuardManifest() === []) {
        Assert::markTestSkipped('Manifest Design Comuni assente: il tema attivo non è Sixteen.');
    }

    $missing = [];
    foreach (contentGuardManifest() as $slug => $row) {
        foreach (['config/local/techplanner/database/content/pages', 'Modules/TechPlanner/config/database/content/pages'] as $dir) {
            if (! is_file(contentGuardRoot().'/'.$dir.'/tests.'.$slug.'.json')) {
                $missing[] = sprintf('riga [%s] -> manca %s/tests.%s.json', $row, $dir, $slug);
            }
        }
    }

    contentGuardAssertNone($missing, 'Righe del manifest senza JSON:');
});

it('lists every tenant tests JSON in the manifest except the documented exceptions', function (): void {
    if (contentGuardManifest() === []) {
        Assert::markTestSkipped('Manifest Design Comuni assente: il tema attivo non è Sixteen.');
    }

    $manifest = contentGuardManifest();
    $exceptions = contentGuardManifestExceptions();
    $tenantSlugs = array_map(
        static fn (string $file): string => substr(basename($file, '.json'), strlen('tests.')),
        contentGuardGlob(contentGuardRoot().'/config/local/techplanner/database/content/pages/tests.*.json'),
    );

    $problems = [];
    foreach ($tenantSlugs as $slug) {
        if (! isset($manifest[$slug]) && ! isset($exceptions[$slug])) {
            $problems[] = sprintf('tests.%s.json non ha una riga nel manifest ne\' un\'eccezione documentata', $slug);
        }
    }
    foreach ($exceptions as $slug => $reason) {
        if (isset($manifest[$slug]) || ! in_array((string) $slug, $tenantSlugs, true)) {
            $problems[] = sprintf('eccezione [%s] superata: ora e\' nel manifest o il JSON non esiste piu\' (%s)', $slug, $reason);
        }
    }

    contentGuardAssertNone($problems, 'Manifest e JSON tests.* non corrispondono:');
});

// (e) un blocco cancellato o rinominato deve rompere questo test, non la pagina.
it('points every pub_theme component view to an existing Blade file', function (string $dir): void {
    $prefix = 'pub_theme::components.';
    $missing = [];
    foreach (contentGuardPagesIn($dir) as $file => $page) {
        foreach (['content_blocks', 'sidebar_blocks', 'footer_blocks'] as $area) {
            foreach (contentGuardViews($page[$area] ?? null, $area) as $where => $view) {
                $blade = 'Themes/'.contentGuardPublicTheme().'/resources/views/components/'.str_replace('.', '/', substr($view, strlen($prefix))).'.blade.php';
                if (str_starts_with($view, $prefix) && ! is_file(contentGuardRoot().'/'.$blade)) {
                    $missing[] = sprintf('%s (%s): vista [%s] -> manca %s', $file, $where, $view, $blade);
                }
            }
        }
    }

    contentGuardAssertNone($missing, 'Blocchi che puntano a una vista Blade inesistente:');
})->with('page directories');

it('finds pub_theme component views to check', function (): void {
    $total = 0;
    foreach (contentGuardPageDirs() as $dir) {
        foreach (contentGuardPagesIn($dir) as $page) {
            $total += count(contentGuardViews($page['content_blocks'] ?? null, 'content_blocks'));
        }
    }

    Assert::assertGreaterThan(0, $total, 'Nessuna chiave `view` trovata nei content_blocks: la guardia (e) non controllerebbe niente.');
});
