<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Docs;

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;
use function Safe\preg_match;
use function Safe\preg_match_all;

/*
 * Regola: Modules/Xot/docs/rules/action-behavioral-contract.md. Source-level (nessuna app).
 * I contratti stanno in docs/contracts/ di ogni modulo e tema; il docblock dell'Action rimanda al file.
 */

const ACTION_CONTRACT_SECTIONS = ['Input', 'Output', 'Invarianti', 'Effetti collaterali', 'Errori', 'Non fa'];

/**
 * Action dei moduli condivisi che trattano dati personali o chiamano servizi esterni: il contratto e' obbligatorio.
 * Le Action del modulo del progetto ospite le elenca il suo test (es. tests/Unit/ActionContractsTest.php del modulo).
 */
const ACTION_CONTRACT_REQUIRED = [
    'Modules/Gdpr/docs/contracts/save-gdpr-consents-action.md',
    'Modules/Geo/docs/contracts/fetch-osm-tile-action.md',
    'Modules/Geo/docs/contracts/query-nominatim-action.md',
    'Modules/AI/docs/contracts/request-assistant-completion-action.md',
];

function laravelRootForContracts(): string
{
    // questo file: Modules/Xot/tests/Unit/Docs -> laravel = 5 livelli sopra
    return dirname(__DIR__, 5);
}

/** @return list<string> problemi del file di contratto; [] se e' completo e collegato all'Action */
function behavioralContractProblems(string $contractPath): array
{
    $root = laravelRootForContracts();
    $source = file_get_contents($contractPath);
    $problems = [];

    $headings = [];
    preg_match_all('/^## (.+)$/m', $source, $headings);
    $found = array_values(array_intersect(array_map('trim', $headings[1]), ACTION_CONTRACT_SECTIONS));
    if ($found !== ACTION_CONTRACT_SECTIONS) {
        $problems[] = 'sezioni '.implode(', ', $found).' invece di '.implode(', ', ACTION_CONTRACT_SECTIONS);
    }

    $match = [];
    if (preg_match('/^action: "?([^"\n]+)"?$/m', $source, $match) !== 1 || ! isset($match[1])) {
        return [...$problems, 'manca action: <FQCN> nella frontmatter'];
    }
    // Modules\Geo\Actions\Osm\X -> Modules/Geo/app/Actions/Osm/X.php
    $parts = explode('\\', str_replace('\\\\', '\\', trim($match[1])));
    $classPath = $root.'/'.$parts[0].'/'.$parts[1].'/app/'.implode('/', array_slice($parts, 2)).'.php';
    if (! is_file($classPath)) {
        return [...$problems, 'l\'Action '.$match[1].' non esiste'];
    }
    if (! str_contains(file_get_contents($classPath), 'Contratto di comportamento: docs/contracts/'.basename($contractPath))) {
        $problems[] = 'il docblock di '.$parts[count($parts) - 1].' non rimanda a docs/contracts/'.basename($contractPath);
    }

    return $problems;
}

it('gives a behavioral contract to every shared-module Action that handles personal data or external services', function (): void {
    $problems = [];
    foreach (ACTION_CONTRACT_REQUIRED as $relative) {
        $path = laravelRootForContracts().'/'.$relative;
        if (! is_file($path)) {
            $problems[] = $relative.': file mancante';

            continue;
        }
        foreach (behavioralContractProblems($path) as $problem) {
            $problems[] = $relative.': '.$problem;
        }
    }

    Assert::assertSame([], $problems);
});

it('keeps every behavioral contract complete and linked from its Action', function (): void {
    $root = laravelRootForContracts();
    $problems = [];
    foreach ([...glob($root.'/Modules/*/docs/contracts/*.md'), ...glob($root.'/Themes/*/docs/contracts/*.md')] as $path) {
        if (! is_string($path) || ! str_contains(file_get_contents($path), "\ntype: contract\n")) {
            continue;
        }
        foreach (behavioralContractProblems($path) as $problem) {
            $problems[] = substr($path, strlen($root) + 1).': '.$problem;
        }
    }

    Assert::assertSame([], $problems);
});
