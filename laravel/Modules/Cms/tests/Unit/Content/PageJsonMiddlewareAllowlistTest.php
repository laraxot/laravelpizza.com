<?php

declare(strict_types=1);

use Modules\Cms\Actions\ValidatePageMiddlewareAction;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\json_decode;

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

test('ogni middleware dichiarato in un JSON di pagina e in allowlist', function (): void {
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
        try {
            app(ValidatePageMiddlewareAction::class)->execute($entries);
        } catch (InvalidArgumentException $exception) {
            Assert::fail($file.': '.$exception->getMessage());
        }
    }
});

test('la guardia legge i JSON del tenant e delle copie nel modulo Fixcity', function (): void {
    $files = dcp283PageJsonFiles();

    Assert::assertGreaterThan(100, count($files));
    Assert::assertNotEmpty(array_filter($files, static fn (string $file): bool => str_ends_with($file, '/tickets/create.json')));
    Assert::assertNotEmpty(array_filter($files, static fn (string $file): bool => str_ends_with($file, '/tickets.create.json')));
});
