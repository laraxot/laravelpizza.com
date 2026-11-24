<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;

/*
 * Insidia (CLAUDE.md): un ServiceProvider di modulo che estende XotBaseServiceProvider senza
 * `protected string $module_ns = __NAMESPACE__;` fa registrare a XotBaseServiceProvider::register() il
 * RouteServiceProvider e l'EventServiceProvider di Xot al posto dei propri. Nessun errore: le rotte del modulo
 * semplicemente non esistono. Trovato il 2026-11-17 su Geo (proxy OpenStreetMap, rotte mai caricate).
 *
 * KNOWN: moduli con il difetto ancora aperto. Correggerli cambia cosa viene caricato (rotte, eventi, migrazioni),
 * quindi si fa uno per volta, misurando: AI ha 11 rotte API dietro auth:sanctum mai registrate (attivarle e' una
 * decisione); Comment e Mobile hanno rotte vuote. Geo registra a mano il proprio RouteServiceProvider.
 * Un modulo nuovo non puo' entrare in questo elenco: va scritto giusto.
 */
const MODULE_NS_KNOWN_DEBT = ['AI', 'Comment', 'Geo', 'Mobile'];

it('declares module_ns in every module service provider, apart from the known debt', function (): void {
    $laravel = dirname(__DIR__, 5);
    $missing = [];
    foreach (glob($laravel.'/Modules/*/app/Providers/*ServiceProvider.php') as $path) {
        if (! is_string($path)) {
            continue;
        }
        $source = file_get_contents($path);
        if (! str_contains($source, 'extends XotBaseServiceProvider') || str_contains($source, 'module_ns = __NAMESPACE__')) {
            continue;
        }
        $module = basename(dirname($path, 3));
        if (! in_array($module, MODULE_NS_KNOWN_DEBT, true)) {
            $missing[] = substr($path, strlen($laravel) + 1);
        }
    }

    Assert::assertSame([], $missing);
});

it('still registers the Geo routes despite the missing module_ns', function (): void {
    $path = dirname(__DIR__, 5).'/Modules/Geo/app/Providers/GeoServiceProvider.php';
    if (! is_file($path)) {
        $this->markTestSkipped('Modulo Geo non presente in questo progetto');
    }
    $source = file_get_contents($path);

    Assert::assertStringContainsString('$this->app->register(RouteServiceProvider::class);', $source);
});
