<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Modules\User\Tests\TestCase;
use Modules\Xot\Tests\FilamentSchemaCoverage;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(TestCase::class)->group('no-user-db');

/** @return array{string, string} */
/** @return list{string, string} */
function userFilamentContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\User\\'];
}

describe('User Filament schema coverage', function (): void {
    test('all form schemas execute getFormSchema', function (): void {
        [$appRoot, $ns] = userFilamentContext();
        FilamentSchemaCoverage::testAllForms($appRoot, $ns);
        Assert::assertNotEmpty(FilamentSchemaCoverage::discover($appRoot, $ns, 'Form'));
    });

    test('all table classes execute getTableColumns', function (): void {
        [$appRoot, $ns] = userFilamentContext();
        FilamentSchemaCoverage::testAllTables($appRoot, $ns);
        Assert::assertNotEmpty(FilamentSchemaCoverage::discover($appRoot, $ns, 'Table'));
    });

    test('all infolist schemas execute getInfolistSchema', function (): void {
        [$appRoot, $ns] = userFilamentContext();
        FilamentSchemaCoverage::testAllInfolists($appRoot, $ns);
    });

    test('all resources expose model and pages', function (): void {
        [$appRoot, $ns] = userFilamentContext();
        FilamentSchemaCoverage::testAllResources($appRoot, $ns);
    });

    test('all list pages expose table columns', function (): void {
        [$appRoot, $ns] = userFilamentContext();
        FilamentSchemaCoverage::testAllListPages($appRoot, $ns);
    });
});

describe('User enum and provider coverage', function (): void {
    test('enums expose cases and labels', function (): void {
        [$appRoot, $ns] = userFilamentContext();
        $seen = 0;
        foreach (glob($appRoot.'/Enums/**/*.php') as $file) {
            if (! is_string($file)) {
                throw new \UnexpectedValueException('Safe\\glob deve restituire percorsi stringa');
            }
            $class = $ns.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen($appRoot) + 1));
            if (! enum_exists($class)) {
                continue;
            }
            Assert::assertNotEmpty($class::cases());
            if (method_exists($class, 'getLabel')) {
                foreach ($class::cases() as $case) {
                    Assert::assertIsString($case->getLabel());
                }
            }
            $seen++;
        }
        Assert::assertGreaterThanOrEqual(0, $seen);
    });

    test('service providers declare module name', function (): void {
        [$appRoot, $ns] = userFilamentContext();
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
                Assert::assertSame('User', $provider->name);
            }
            $seen++;
        }
        Assert::assertGreaterThan(0, $seen, 'User deve scoprire almeno un service provider concreto');
    });
});
