<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Composer\InstalledVersions;
use Composer\Semver\Constraint\Constraint;
use Composer\Semver\VersionParser;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\json_decode;

uses(XotBaseTestCase::class);

/**
 * I vincoli dei pacchetti del monorepo stanno in Modules/Xot/composer.json (merge-plugin). Un vendor rimasto
 * sotto il minimo dichiarato si presenta in PHPStan come `method.deprecated` o `attribute.notFound` sul codice
 * scritto per il vendor nuovo, e chi lo legge "corregge" il codice all'indietro, finche' un altro ambiente lo
 * rigira: #[Exposed] e $isLazyLoaded il 2026-11-05, form()/schema() sui filtri il 2026-11-10 (Filament 5.11.2).
 * Qui lo stesso vendor fallisce con il nome del pacchetto e il comando da lanciare.
 *
 * Story: Modules/Xot/docs/stories/filament-5-11-2-filter-form-naming.story.md
 *
 * @return array<string, array{0: string, 1: string}>
 */
function xotDeclaredPackageConstraints(): array
{
    $composer = json_decode(file_get_contents(dirname(__DIR__, 2).'/composer.json'), true);
    $rows = [];
    if (! is_array($composer)) {
        return $rows;
    }

    foreach (['require', 'require-dev'] as $section) {
        $requirements = $composer[$section] ?? [];
        if (! is_array($requirements)) {
            continue;
        }

        foreach ($requirements as $package => $constraint) {
            // php, ext-*, lib-*, composer-plugin-api non sono pacchetti installati in vendor/.
            if (! is_string($package) || ! is_string($constraint) || ! str_contains($package, '/')) {
                continue;
            }

            $rows[$package] = [
                $package,
                $constraint,
            ];
        }
    }

    return $rows;
}

it('il vendor soddisfa il vincolo di Modules/Xot/composer.json', function (string $package, string $constraint): void {
    if (! InstalledVersions::isInstalled($package)) {
        $this->markTestSkipped($package.' non installato (installazione --no-dev)');
    }

    Assert::assertTrue(
        InstalledVersions::satisfies(new VersionParser, $package, $constraint),
        $package.' installato '.(InstalledVersions::getPrettyVersion($package) ?? '?').', dichiarato '.$constraint
        .': il vendor e\' indietro. Lanciare `cd laravel && composer update '.$package
        .' -W`, non riscrivere il codice per il vendor vecchio.',
    );
})->with(xotDeclaredPackageConstraints());

it('il vincolo su filament/filament esclude le versioni con form() deprecato sui filtri', function (): void {
    $declared = xotDeclaredPackageConstraints()['filament/filament'][1] ?? null;
    Assert::assertIsString($declared, 'filament/filament non e\' piu\' dichiarato in Modules/Xot/composer.json');

    // Fino a 5.11.1 il canonico dei filtri e' schema() e form() e' deprecato; da 5.11.2 e' il contrario
    // (filamentphp/filament#20956). Il codice usa form(): un vincolo che ammette 5.11.1 riapre il ping-pong.
    $constraint = (new VersionParser)->parseConstraints($declared);
    Assert::assertFalse(
        $constraint->matches(new Constraint('==', '5.11.1.0')),
        'filament/filament '.$declared.' ammette 5.11.1: il minimo deve restare ^5.11.2.',
    );
});
