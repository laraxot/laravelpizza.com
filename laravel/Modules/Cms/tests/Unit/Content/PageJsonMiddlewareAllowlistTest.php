<?php

declare(strict_types=1);

use Modules\Cms\Actions\ValidatePageMiddlewareAction;
<<<<<<< HEAD
=======
use Modules\Cms\Tests\TestCase;
>>>>>>> laraxot/dev
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\json_decode;

<<<<<<< HEAD
=======
// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
/*
 * DCP-283 (C-03): nessuna pagina esistente deve cambiare comportamento. Si percorrono TUTTI i JSON di pagina del
 * repository (tenant in `config/*` e `config/*\/*`, configurazioni dei moduli e dei temi) e ogni `middleware`
 * dichiarato deve essere nella allowlist.
 */

/**
 * @return list<string> percorsi dei JSON sotto una cartella `database/content/pages`
 */
function dcp283PageJsonFiles(): array
{
    $finder = Finder::create()
        ->files()
        ->in([base_path('config'), base_path('Modules/*/config'), base_path('Themes/*/config')])
        ->path('database/content/pages')
        ->name('*.json');

    $files = [];
    foreach ($finder as $file) {
        $files[] = $file->getPathname();
    }
    sort($files);

    return $files;
}

<<<<<<< HEAD
test('ogni middleware dichiarato in un JSON di pagina e in allowlist', function (): void {
=======
test('ogni middleware dichiarato in un JSON di pagina è un alias CMS o un middleware owner', function (): void {
>>>>>>> laraxot/dev
    $declaredByFile = [];
    foreach (dcp283PageJsonFiles() as $file) {
        $decoded = json_decode(file_get_contents($file), true);
        Assert::assertIsArray($decoded, $file);
        if (null === ($decoded['middleware'] ?? null)) {
            continue;
        }
        Assert::assertIsArray($decoded['middleware'], $file.': middleware non e una lista');
        $declaredByFile[$file] = $decoded['middleware'];
    }

    $stringsByFile = [];

    // Sanita': la guardia deve vedere le pagine protette note, altrimenti non controlla nulla.
    $names = [];
    foreach ($declaredByFile as $file => $list) {
        $entries = [];
        foreach ($list as $entry) {
            Assert::assertIsString($entry, $file);
            $entries[] = $entry;
            $names[explode(':', $entry, 2)[0]] = true;
        }
        $stringsByFile[$file] = $entries;
    }
    Assert::assertArrayHasKey('auth', $names, 'nessun JSON dichiara auth: la guardia non vede le pagine protette');
    Assert::assertArrayHasKey('throttle', $names, 'nessun JSON dichiara throttle');

    foreach ($stringsByFile as $file => $entries) {
<<<<<<< HEAD
        try {
            app(ValidatePageMiddlewareAction::class)->execute($entries);
        } catch (InvalidArgumentException $exception) {
            Assert::fail($file.': '.$exception->getMessage());
        }
=======
        $cmsEntries = array_values(array_filter(
            $entries,
            static fn (string $entry): bool => ! str_contains(explode(':', $entry, 2)[0], '\\'),
        ));

        try {
            app(ValidatePageMiddlewareAction::class)->execute($cmsEntries);
        } catch (InvalidArgumentException $exception) {
            Assert::fail($file.': '.$exception->getMessage());
        }

        foreach ($entries as $entry) {
            $name = explode(':', $entry, 2)[0];
            if (! str_contains($name, '\\')) {
                continue;
            }

            Assert::assertTrue(class_exists($name), $file.': middleware owner inesistente '.$name);
        }
>>>>>>> laraxot/dev
    }
});

test('la guardia legge i JSON del tenant e delle copie nel modulo Fixcity', function (): void {
    $files = dcp283PageJsonFiles();

    Assert::assertGreaterThan(100, count($files));
    Assert::assertNotEmpty(array_filter($files, static fn (string $file): bool => str_ends_with($file, '/tickets/create.json')));
    Assert::assertNotEmpty(array_filter($files, static fn (string $file): bool => str_ends_with($file, '/tickets.create.json')));
});
