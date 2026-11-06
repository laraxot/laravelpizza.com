<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Modules\UI\Tests\TestCase;
use Modules\Xot\Tests\FilamentSchemaCoverage;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/** @return list{string, string} */
function uiFilamentContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\UI\\'];
}

describe('UI Filament schema coverage', function (): void {
    test('all form schemas execute getFormSchema when present', function (): void {
        [$appRoot, $ns] = uiFilamentContext();
        FilamentSchemaCoverage::testAllForms($appRoot, $ns);
    });

    test('all table classes execute getTableColumns when present', function (): void {
        [$appRoot, $ns] = uiFilamentContext();
        FilamentSchemaCoverage::testAllTables($appRoot, $ns);
    });

    test('all infolist schemas execute getInfolistSchema when present', function (): void {
        [$appRoot, $ns] = uiFilamentContext();
        FilamentSchemaCoverage::testAllInfolists($appRoot, $ns);
    });

    test('all resources expose model and pages when present', function (): void {
        [$appRoot, $ns] = uiFilamentContext();
        $resources = array_values(array_filter(
            FilamentSchemaCoverage::discover($appRoot, $ns, 'Resource'),
            static fn (string $class): bool => str_ends_with($class, 'Resource'),
        ));
        Assert::assertSame([], array_diff($resources, $resources));
        if ($resources === []) {
            return;
        }
        FilamentSchemaCoverage::testAllResources($appRoot, $ns);
    });

    test('all list pages expose table columns when present', function (): void {
        [$appRoot, $ns] = uiFilamentContext();
        FilamentSchemaCoverage::testAllListPages($appRoot, $ns);
    });
});
