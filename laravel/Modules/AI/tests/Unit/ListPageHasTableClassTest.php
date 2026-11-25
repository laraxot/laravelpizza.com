<?php

declare(strict_types=1);
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;

uses(TestCase::class);

/*
 * Da quando `XotBaseListRecords` non usa piu' `HasXotTable`, la tabella di una list page
 * la costruisce `XotBaseResource::table()` attraverso `getTableClass()`, che alza
 * `LogicException` se la classe non esiste: una Resource senza `*Table` non degrada a
 * tabella vuota, va in errore a runtime.
 *
 * Questo test tiene il contratto: nessuna list page concreta puo' restare scoperta.
 */

test('ogni list page concreta risolve la sua Table class', function (): void {
    $senzaTable = [];

    /** @var list<string> $files */
    $files = glob(base_path('Modules/*/app/Filament/Resources/*/Pages/*.php')) ?: [];

    foreach ($files as $file) {
        $src = file_get_contents($file);

        if (! preg_match('/extends\s+\w*ListRecords/', $src)) {
            continue;
        }
        if (preg_match('/^abstract class/m', $src)) {
            continue;
        }
        if (! preg_match('/namespace\s+([^;]+);/', $src, $ns)) {
            continue;
        }
        if (! preg_match('/^(?:final\s+)?class\s+(\w+)/m', $src, $className)) {
            continue;
        }

        $page = trim($ns[1]).'\\'.$className[1];
        if (! class_exists($page)) {
            continue;
        }

        try {
            /** @var class-string<XotBaseResource> $resourceClass */
            $resourceClass = $page::getResource();
            $resourceClass::getTableClass();
        } catch (Throwable $e) {
            $senzaTable[] = $page.' — '.$e->getMessage();
        }
    }

    Assert::assertSame([], $senzaTable, "List page senza Table class:\n".implode("\n", $senzaTable));
});
