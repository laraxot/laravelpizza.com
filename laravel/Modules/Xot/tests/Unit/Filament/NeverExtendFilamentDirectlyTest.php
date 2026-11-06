<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament;

use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * Non si estende mai una classe Filament direttamente: si estende la sua XotBase.
 *
 * È una regola scritta del progetto, e viene dimenticata perché **la documentazione
 * di Filament insegna l'opposto**. Chi costruisce un componente parte dal manuale del
 * framework — `class X extends TextColumn` — e quella è la forma giusta *fuori* di
 * qui. Il progetto la inverte, e l'inversione non ha nulla che la ricordi al momento
 * in cui si scrive la riga.
 *
 * Il 2026-09-08 l'ho violata tre volte in un pomeriggio, mentre scrivevo componenti
 * nuovi: `RatingsColumn extends TextColumn`, `HasRatingValuesFilter extends
 * TernaryFilter`, `WorkerTypeFilter extends Filter`. Nessuna delle tre dava errore.
 *
 * Debito storico residuo: 0 file (wave 2026-10-22: tutti i componenti
 * Notify, Blog, Fixcity, UI, Xot mock bonificati a XotBase*).
 * Tetto decrescente: la guardia non pretende zero, impedisce che il numero salga.
 *
 * @see docs/wiki/rules/fundamental-xotbase-rule.md
 */

/**
 * Classi Filament che hanno una XotBase e quindi non vanno estese direttamente.
 *
 * @return array<string, string> classe Filament => XotBase da usare
 */
function filamentBasesWithXotEquivalent(): array
{
    return [
        'RelationManager' => 'XotBaseRelationManager',
        'TextColumn' => 'XotBaseTextColumn',
        'IconColumn' => 'XotBaseIconColumn',
        'SelectColumn' => 'XotBaseSelectColumn',
        'ViewColumn' => 'XotBaseViewColumn',
        'ColumnGroup' => 'XotBaseColumnGroup',
        'SelectFilter' => 'XotBaseSelectFilter',
        'TernaryFilter' => 'XotBaseTernaryFilter',
        'Filter' => 'XotBaseFilter',
        'Section' => 'XotBaseSection',
        // Wave qualità 2026-10-20 — blueprint Filament
        'Select' => 'XotBaseSelect',
        'Field' => 'XotBaseField',
        'TextInput' => 'XotBaseTextInput',
        'Widget' => 'XotBaseWidget',
    ];
}

/*
 * GateGuard test: behaviour = ratchet never-extend-Filament; module Xot;
 * existing file this; user: "migliora qualità codice , fa tutto con bmad + second brain + filament blueprint"
 */

/**
 * @return array<string, string> file => violazione
 */
function classesExtendingFilamentDirectly(): array
{
    $offenders = [];
    $bases = filamentBasesWithXotEquivalent();
    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator(base_path('Modules'), \FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $fileInfo) {
        if (! $fileInfo instanceof \SplFileInfo || $fileInfo->getExtension() !== 'php') {
            continue;
        }

        $path = $fileInfo->getPathname();

        if (! str_contains($path, '/Filament/') || str_contains($path, '/vendor/')) {
            continue;
        }

        // Le XotBase stesse estendono Filament: è il loro lavoro.
        if (str_contains($fileInfo->getFilename(), 'XotBase')) {
            continue;
        }

        $source = file_get_contents($path);
        $match = [];

        if (preg_match('/^\s*(?:final\s+|abstract\s+)*class\s+\w+\s+extends\s+(\w+)/m', $source, $match) !== 1) {
            continue;
        }

        $parent = (string) ($match[1] ?? '');

        if (! isset($bases[$parent])) {
            continue;
        }

        // `extends TextColumn` dove TextColumn è un alias di import di una XotBase
        // non è una violazione: conta cosa importa, non come lo chiama.
        if (preg_match('/use\s+Modules\\\\[\w\\\\]*XotBase\w*\s+as\s+'.preg_quote($parent, '/').'\s*;/', $source) === 1) {
            continue;
        }

        $offenders[str_replace(base_path().'/', '', $path)] = $parent.' → usa '.$bases[$parent];
    }

    return $offenders;
}

/**
 * Tetto dopo wave qualità Notify+UI XotBase*: **0 file** residuo
 * Tutte le classi Filament ora si estendono via XotBase.
 * Non deve salire mai.
 */
const FILAMENT_DIRECT_EXTENDS_BASELINE = 0;

test('nessuna classe nuova estende Filament al posto della sua XotBase', function (): void {
    $offenders = classesExtendingFilamentDirectly();

    $detail = '';
    foreach ($offenders as $file => $what) {
        $detail .= "\n  {$file}\n    {$what}";
    }

    Assert::assertLessThanOrEqual(
        FILAMENT_DIRECT_EXTENDS_BASELINE,
        count($offenders),
        'La documentazione di Filament insegna a estendere le sue classi: qui no. '.
        "Ogni componente passa dalla sua XotBase.\nViolazioni:".$detail
    );
});

test('il tetto resta allineato al debito, cosi la guardia continua a misurare', function (): void {
    Assert::assertGreaterThan(
        FILAMENT_DIRECT_EXTENDS_BASELINE - 10,
        count(classesExtendingFilamentDirectly()),
        'Sono stati bonificati piu\' di 10 file: abbassa FILAMENT_DIRECT_EXTENDS_BASELINE al numero attuale.'
    );
});
