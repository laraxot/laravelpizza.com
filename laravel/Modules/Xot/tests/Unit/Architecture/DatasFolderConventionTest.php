<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Architecture;

use Illuminate\Support\Facades\File;
use Modules\Xot\Tests\TestCase;
use Spatie\LaravelData\Support\Caching\DataClassFinder;

use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class);

/*
 * Convenzione Laraxot (prompt bashscripts/docs/prompts/04-datas-not-dtos.md, story Xot datas-folder-convention-guard):
 * i data object estendono Spatie\LaravelData\Data e vivono in `app/Datas`, al plurale come `Actions`, `Models`, `Enums`:
 * la cartella si ricava dal suffisso della classe (`*Data` -> `Datas/`, `*Action` -> `Actions/`). I test la rispecchiano.
 * Vietate: `Data` singolare (il default di `make:data` di Spatie, da cui nascevano), `DTOs`/`Dto`, `DataObjects`,
 * `DataTransferObjects`. Conta solo il codice caricabile (`*.php`): una cartella vuota o con i soli `.old` non viola.
 */
test('i data object vivono solo in app/Datas (e i loro test in tests/*/Datas)', function (): void {
    $folders = ['Data', 'DTO', 'DTOs', 'Dto', 'Dtos', 'DataObjects', 'DataTransferObjects'];
    $found = [];
    foreach ([base_path('Modules'), base_path('Themes')] as $root) {
        foreach (File::allDirectories($root) as $dir) {
            if (! is_string($dir)) {
                continue;
            }

            if (! preg_match('#/(app|tests/(Unit|Feature))/([^/]+)$#', $dir, $matches)) {
                continue;
            }
            if (! in_array($matches[3], $folders, true)) {
                continue;
            }

            foreach (File::allFiles($dir) as $file) {
                if ('php' === $file->getExtension()) {
                    $found[] = ltrim(str_replace(base_path(), '', $file->getPathname()), '/');
                }
            }
        }
    }
    sort($found);

    expect($found)->toBe([]);
});

/*
 * Ogni classe dichiarata in `app/Datas` si carica da sola (una classe per file, PSR-4). E' la stessa ricerca che fa
 * `data:cache-structures` dentro `php artisan optimize` al deploy (config/data.php, parser): una classe che non si carica
 * fa fallire il comando e, con `set -e`, il deploy. Caso del 2026-10-23: `ArticleDataCore` e `ArticleDataBlocks`
 * stavano dentro `Blog/app/Datas/ArticleData.php` e funzionavano solo se `ArticleData` era gia' stata caricata.
 */
test('ogni classe trovata in app/Datas si carica da sola', function (): void {
    $directories = array_values(array_filter(glob(base_path('Modules/*/app/Datas'), GLOB_ONLYDIR), is_string(...)));
    $classes = (new DataClassFinder($directories, false, base_path(), null))->classes();
    $notLoadable = [];
    foreach ($classes as $class) {
        if (! is_string($class) || ! class_exists($class)) {
            $notLoadable[] = $class;
        }
    }

    expect($classes)->not->toBeEmpty()
        ->and($notLoadable)->toBe([]);
});
