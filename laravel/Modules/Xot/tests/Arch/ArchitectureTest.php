<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Arch;

use PHPUnit\Framework\Assert;

require_once __DIR__.'/scope.php';

/*
 * Regole di architettura di tutti i moduli e temi, con Pest arch() (pestphp/pest-plugin-arch).
 *
 * - Nessuna applicazione, nessun database: girano in pochi secondi anche senza MariaDB.
 * - L'ambito e' production_namespaces() (scope.php), mai `Modules`: con nwidart quel namespace non e' un prefisso PSR-4
 *   e la regola passerebbe senza controllare nulla. Il primo test lo verifica.
 * - Il debito (tests/Arch/debt.php di ogni pacchetto) e' quello di oggi, classe per classe: Pest non ha una baseline, quindi il debito e' una lista visibile
 *   che puo' solo scendere. Chi corregge una classe la toglie dalla lista; chi aggiunge una voce lo spiega nella PR.
 *   Il test «debt entries still exist» fa fallire le voci di classi cancellate o rinominate.
 *
 * ADR: Modules/Xot/docs/adr/architecture-tests-pest-arch.md. Rilancio: vendor/bin/pest --testsuite=Arch
 */

/**
 * Famiglie Filament/Laravel che nei moduli si estendono solo attraverso la base Xot (regola XotBase).
 *
 * @var array<class-string, class-string>
 */
const XOTBASE_FAMILIES = [
    'Filament\Resources\Resource' => 'Modules\Xot\Filament\Resources\XotBaseResource',
    'Filament\Resources\Pages\CreateRecord' => 'Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord',
    'Filament\Resources\Pages\EditRecord' => 'Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord',
    'Filament\Resources\Pages\ManageRecords' => 'Modules\Xot\Filament\Resources\Pages\XotBaseManageRecords',
    'Filament\Resources\RelationManagers\RelationManager' => 'Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager',
    'Filament\Widgets\ChartWidget' => 'Modules\Xot\Filament\Widgets\XotBaseChartWidget',
    'Filament\Widgets\StatsOverviewWidget' => 'Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget',
    'Filament\Widgets\TableWidget' => 'Modules\Xot\Filament\Widgets\XotBaseTableWidget',
];

/**
 * Debito di architettura dichiarato da ogni pacchetto in `tests/Arch/debt.php` (regola => classi), unito per regola.
 * Il debito sta nel pacchetto che lo possiede: i moduli condivisi non nominano il progetto ospite, e ogni repository di
 * modulo porta con se' il proprio.
 *
 * @return array<string, list<string>>
 */
function all_arch_debt(): array
{
    static $debt = null;
    if (is_array($debt)) {
        return $debt;
    }

    $debt = [];
    foreach (debt_files() as $file) {
        foreach (read_debt_file($file) as $rule => $entries) {
            $debt[$rule] = [...($debt[$rule] ?? []), ...$entries];
        }
    }

    return $debt;
}

/** Regole che accettano debito: le chiavi ammesse in tests/Arch/debt.php. */
const ARCH_RULES = ['php', 'security', 'strict', 'services', 'xotbase'];

/**
 * @return list<string>
 */
function arch_debt(string $rule): array
{
    return all_arch_debt()[$rule] ?? [];
}

function class_like_exists(string $name): bool
{
    return class_exists($name) || interface_exists($name) || trait_exists($name) || enum_exists($name);
}

it('resolves every namespace in scope, so no rule passes on an empty set', function (): void {
    Assert::assertNotSame([], production_namespaces('modules'));
    Assert::assertSame([], unresolvable_namespaces(production_namespaces()));
});

/*
 * Pest `ignoring()` confronta i nomi per prefisso di stringa (Blueprint: str_starts_with): ignorare
 * `Modules\AI\Services\AIService` nasconde anche `Modules\AI\Services\AIServicePromptBuilder`. Ogni classe nascosta cosi'
 * deve comparire nella stessa lista, altrimenti il debito sarebbe piu' grande di quello dichiarato.
 */
it('hides no class behind a debt entry by string prefix', function (): void {
    $classes = production_classes();
    $hidden = [];
    foreach (all_arch_debt() as $rule => $entries) {
        foreach ($entries as $entry) {
            foreach ($classes as $class) {
                if ($class !== $entry && str_starts_with($class, $entry) && ! in_array($class, $entries, true)) {
                    $hidden[] = $rule.': '.$entry.' nasconde '.$class;
                }
            }
        }
    }

    Assert::assertSame([], $hidden);
});

it('keeps each debt entry in the package that owns it, with known rules only', function (): void {
    $problems = [];
    foreach (debt_files() as $owner => $file) {
        foreach (read_debt_file($file) as $rule => $entries) {
            if (! in_array($rule, ARCH_RULES, true)) {
                $problems[] = $owner.': regola sconosciuta '.$rule;
            }
            foreach ($entries as $entry) {
                if (! str_starts_with($entry, $owner.'\\')) {
                    $problems[] = $owner.': '.$entry.' appartiene a un altro pacchetto';
                }
            }
        }
    }

    Assert::assertSame([], $problems);
});

it('keeps only debt entries that still exist', function (): void {
    $stale = [];
    foreach (all_arch_debt() as $rule => $entries) {
        foreach ($entries as $entry) {
            if (! class_like_exists($entry)) {
                $stale[] = $rule.': '.$entry;
            }
        }
    }

    Assert::assertSame([], $stale);
});

arch('no debug or deprecated functions (preset php)')
    ->preset()->php()
    ->ignoring([...test_namespaces(), ...arch_debt('php')]);

// Factory e seeder producono dati finti (rand, uniqid): fuori dalla regola, non sono codice che gira in produzione.
arch('no risky functions (preset security)')
    ->preset()->security()
    ->ignoring([...test_namespaces(), ...database_namespaces(), ...arch_debt('security')]);

arch('production code declares strict types')
    ->expect(production_namespaces())
    ->toUseStrictTypes()
    ->ignoring(arch_debt('strict'));

// Sul namespace, non sul suffisso: `Themes\Sixteen\Models\Service` e' un modello di dominio (un servizio comunale), non un Service.
arch('a use case is an Action, not a Service')
    ->expect(array_map(static fn (string $namespace): string => $namespace.'\Services', production_namespaces()))
    ->not->toBeClasses()
    ->ignoring(arch_debt('services'));

// Un arch() per modulo: con un array di target `not->toUse()` passa se ANCHE UNO SOLO non usa la dipendenza
// (Blueprint::expectToUse + OppositeExpectation), quindi un array nasconderebbe le violazioni degli altri.
foreach (production_namespaces('modules') as $module) {
    arch($module.' does not depend on themes')
        ->expect($module)
        ->not->toUse(production_namespaces('themes')); // `Themes` da solo non e' un prefisso PSR-4: non vedrebbe nulla
}

foreach (XOTBASE_FAMILIES as $filament => $xotBase) {
    arch('Filament '.class_basename($filament).' is extended through '.class_basename($xotBase))
        ->expect(production_namespaces())
        ->classes()
        ->extending($filament)
        ->toExtend($xotBase)
        ->ignoring([$xotBase, ...arch_debt('xotbase')]);
}
