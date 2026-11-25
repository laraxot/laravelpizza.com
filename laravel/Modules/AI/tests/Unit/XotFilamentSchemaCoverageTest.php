<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\FilamentSchemaCoverage;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(TestCase::class)->group('no-xot-db');

/** @return array{string, string} */
/** @return list{string, string} */
function xotFilamentContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\Xot\\'];
}

describe('Xot Filament schema coverage', function (): void {
    test('all form schemas execute getFormSchema', function (): void {
        [$appRoot, $ns] = xotFilamentContext();
        FilamentSchemaCoverage::testAllForms($appRoot, $ns);
    });

    test('all table classes execute getTableColumns', function (): void {
        [$appRoot, $ns] = xotFilamentContext();
        FilamentSchemaCoverage::testAllTables($appRoot, $ns);
    });

    test('all infolist schemas execute getInfolistSchema', function (): void {
        [$appRoot, $ns] = xotFilamentContext();
        FilamentSchemaCoverage::testAllInfolists($appRoot, $ns);
    });

    test('all resources expose model and pages', function (): void {
        [$appRoot, $ns] = xotFilamentContext();
        FilamentSchemaCoverage::testAllResources($appRoot, $ns);
    });

    test('all list pages expose table columns', function (): void {
        [$appRoot, $ns] = xotFilamentContext();
        FilamentSchemaCoverage::testAllListPages($appRoot, $ns);
    });
});

describe('Xot enum and provider coverage', function (): void {
    test('enums expose cases', function (): void {
        [$appRoot, $ns] = xotFilamentContext();
        $seen = 0;
        foreach (glob($appRoot.'/Enums/*.php') as $file) {
            if (! is_string($file)) {
                throw new \UnexpectedValueException('Safe\\glob deve restituire percorsi stringa');
            }
            $class = $ns.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen($appRoot) + 1));
            if (! enum_exists($class)) {
                continue;
            }
            Assert::assertNotEmpty($class::cases());
            $seen++;
        }
        Assert::assertGreaterThan(0, $seen, 'Xot deve scoprire almeno un enum concreto');
    });

    test('service providers declare module name', function (): void {
        [$appRoot, $ns] = xotFilamentContext();
        $seen = 0;
        foreach (glob($appRoot.'/Providers/*ServiceProvider.php') as $file) {
            if (! is_string($file)) {
                throw new \UnexpectedValueException('Safe\\glob deve restituire percorsi stringa');
            }
            $class = $ns.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen($appRoot) + 1));
            if (! class_exists($class)) {
                continue;
            }
            $ref = new \ReflectionClass($class);
            if ($ref->isAbstract()) {
                continue;
            }
            $provider = new $class(app());
            if (property_exists($provider, 'name')) {
                Assert::assertSame('Xot', $provider->name);
            }
            $seen++;
        }
        Assert::assertGreaterThan(0, $seen, 'Xot deve scoprire almeno un service provider concreto');
    });
});
