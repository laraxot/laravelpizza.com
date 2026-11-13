<?php

declare(strict_types=1);

use Symfony\Component\Finder\Finder;

use function Safe\glob;
use function Safe\preg_match;
use function Safe\preg_match_all;

/*
|--------------------------------------------------------------------------
| Architettura dei moduli (gate cross-module)
|--------------------------------------------------------------------------
|
| Regole dei prompt 25-services-to-actions e 14-module-dependency-direction
| (bashscripts/docs/prompts). Il test non avvia Laravel e non usa il DB:
| legge solo i file PHP sotto Modules/<Modulo>/app.
|
| Collocazione: Modules/Xot/tests/Architecture/, dal 2026-11-11 (prima stava in
| laravel/tests/Architecture/, cartella sciolta). E' un gate trasversale a
| tutti i moduli e sta nel modulo base.
|
| Esecuzione: ./vendor/bin/pest --test-directory=Modules/Xot/tests Modules/Xot/tests/Architecture
*/

/**
 * Cartella `laravel/Modules`, calcolata da questo file
 * (Modules/Xot/tests/Architecture). Con lo spostamento del 2026-11-11 il vecchio
 * `dirname(__DIR__, 2).'/Modules'` puntava a Modules/Xot/Modules, che non esiste:
 * il Finder restava senza cartelle e quattro test su cinque morivano con
 * LogicException invece di controllare i moduli.
 */
function archModulesRoot(): string
{
    return dirname(__DIR__, 3);
}

/**
 * Cicli noti tra due moduli (debito esistente). Si riduce, non si aumenta:
 * quando ne risolvi uno, toglilo da qui (il test lo richiede).
 *
 * @return list<string>
 */
function archKnownModuleCycles(): array
{
    return [
        'Activity<->User',
        'Lang<->Xot',
        'Limesurvey<->Quaeris',
        'Media<->User',
        'Media<->Xot',
        'Notify<->User',
        'Notify<->Xot',
        'Tenant<->Xot',
        'UI<->User',
        'UI<->Xot',
        'User<->Xot',
    ];
}

/**
 * `Safe\glob()` dichiara solo `list`: qui si tengono i percorsi, che sono stringhe.
 *
 * @return list<string>
 */
function archGlob(string $pattern, int $flags = 0): array
{
    return array_values(array_filter(glob($pattern, $flags), is_string(...)));
}

function archModuleFiles(): Finder
{
    return (new Finder)->files()->in(archGlob(archModulesRoot().'/*/app'))->name('*.php');
}

/**
 * @return array<string, list<string>> modulo => moduli importati con `use Modules\X\...`
 */
function archModuleDependencies(): array
{
    $dependencies = [];

    foreach (archModuleFiles() as $file) {
        preg_match('#/Modules/([^/]+)/app/#', $file->getPathname(), $owner);
        if (! isset($owner[1])) {
            continue;
        }
        $module = $owner[1];

        preg_match_all('/^use\s+Modules\\\\([A-Za-z]+)\\\\/m', $file->getContents(), $imports);

        foreach ($imports[1] as $imported) {
            if ($imported !== $module) {
                $dependencies[$module][$imported] = $imported;
            }
        }
    }

    return array_map(static fn (array $imported): array => array_values($imported), $dependencies);
}

/**
 * Falsi positivi documentati: nome *Service.php ma NON logica applicativa Service.
 * W0 REUSE: TermsOfService Livewire ritirato (gemello TermsOfServiceWidget).
 * Allowlist vuota = nessun *Service.php fuori da Services/ ammesso.
 *
 * @return list<string>
 */
function archAllowedServiceNamedPhp(): array
{
    return [];
}

/**
 * Cartelle Modules/<Modulo>/app/Services ammesse solo finche' la conversione in Queueable Actions e' in corso.
 * La cartella NON deve esistere, nemmeno vuota o con soli adapter: gli adapter vivono in Adapters/, Contracts/
 * o Datas/. Si riduce, non si aumenta: quando una sparisce, toglila da qui (il test lo richiede).
 *
 * @return list<string>
 */
function archAllowedServicesDirs(): array
{
    return [];
}

/**
 * Path relativo Modules/... per un file Finder.
 */
function archModuleRelativePath(SplFileInfo $file): string
{
    $pathname = $file->getPathname();

    return substr($pathname, (int) strpos($pathname, 'Modules/'));
}

it('has no applicative *Service.php under Modules/*/app (Queueable Actions instead)', function (): void {
    $offenders = [];

    foreach (archModuleFiles() as $file) {
        $path = archModuleRelativePath($file);

        if (! str_ends_with($path, 'Service.php')) {
            continue;
        }

        if (in_array($path, archAllowedServiceNamedPhp(), true)) {
            continue;
        }

        $offenders[] = $path;
    }

    expect($offenders)->toBe([]);
});

it('ratchets against resurrection of Modules/*/app/Services/**/*Service.php (anti-merge laraxot/dev)', function (): void {
    // I *Service.php applicativi riesumati dal merge devono fallire CI. La cartella stessa e' vietata dal
    // test successivo: qui si segnala il file, li' la directory.
    $offenders = [];

    foreach (archModuleFiles() as $file) {
        $path = archModuleRelativePath($file);

        if (preg_match('#^Modules/[^/]+/app/Services/.+Service\.php$#', $path) === 1) {
            $offenders[] = $path;
        }
    }

    expect($offenders)->toBe([]);
});

it('has no Modules/*/app/Services directory (Queueable Actions, adapters elsewhere)', function (): void {
    $found = [];

    foreach (archGlob(archModulesRoot().'/*/app/Services', GLOB_ONLYDIR) as $dir) {
        $found[] = substr($dir, (int) strpos($dir, 'Modules/'));
    }

    sort($found);

    expect(array_values(array_diff($found, archAllowedServicesDirs())))->toBe([], 'cartelle Services riesumate')
        ->and(array_values(array_diff(archAllowedServicesDirs(), $found)))
        ->toBe([], 'cartelle Services ritirate: toglile dalla allowlist');
});

it('keeps UI independent from Geo', function (): void {
    expect(archModuleDependencies()['UI'] ?? [])->not->toContain('Geo');
});

it('introduces no new module dependency cycles and drops the fixed ones from the baseline', function (): void {
    $dependencies = archModuleDependencies();
    $cycles = [];

    foreach ($dependencies as $from => $targets) {
        foreach ($targets as $to) {
            if (in_array($from, $dependencies[$to] ?? [], true)) {
                $pair = [$from, $to];
                sort($pair);
                $cycles[implode('<->', $pair)] = implode('<->', $pair);
            }
        }
    }

    $found = array_values($cycles);
    sort($found);

    expect(array_values(array_diff($found, archKnownModuleCycles())))->toBe([], 'nuovi cicli tra moduli')
        ->and(array_values(array_diff(archKnownModuleCycles(), $found)))
        ->toBe([], 'cicli risolti: toglili dalla baseline');
});

it('has no PHP classes under app/Console (commands live in Modules/*/app/Console/Commands)', function (): void {
    // Comandi artisan belong to the owning module: XotBaseServiceProvider::registerCommands()
    // scans Modules/<M>/app/Console/Commands. A file under laravel/app/Console is auto-discovered
    // by Laravel silently, bypasses git/module boundaries and already happened once in production
    // (SendTestMail.php, story send-test-mail-wrong-location).
    $consoleDir = dirname(archModulesRoot()).'/app/Console';
    $offenders = [];

    if (is_dir($consoleDir)) {
        foreach ((new Finder)->files()->in($consoleDir)->name('*.php') as $file) {
            $offenders[] = $file->getPathname();
        }
    }

    sort($offenders);

    expect($offenders)->toBe([]);
});
