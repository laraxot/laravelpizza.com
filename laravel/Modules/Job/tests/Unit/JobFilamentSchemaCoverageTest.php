<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Modules\Job\Tests\TestCase;
use Modules\Xot\Tests\FilamentSchemaCoverage;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(TestCase::class)->group('no-job-db');

/** @return list{string, string} */
function jobFilamentContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\Job\\'];
}

/** @return list<string> */
function jobPhpFiles(string $pattern): array
{
    return array_values(array_filter(glob($pattern), is_string(...)));
}

describe('Job Filament schema coverage', function (): void {
    test('all form schemas execute getFormSchema', function (): void {
        [$appRoot, $ns] = jobFilamentContext();
        FilamentSchemaCoverage::testAllForms($appRoot, $ns);
        Assert::assertNotEmpty(FilamentSchemaCoverage::discover($appRoot, $ns, 'Form'));
    });

    test('all table classes execute getTableColumns', function (): void {
        [$appRoot, $ns] = jobFilamentContext();
        FilamentSchemaCoverage::testAllTables($appRoot, $ns);
        Assert::assertNotEmpty(FilamentSchemaCoverage::discover($appRoot, $ns, 'Table'));
    });

    test('all infolist schemas execute getInfolistSchema', function (): void {
        [$appRoot, $ns] = jobFilamentContext();
        FilamentSchemaCoverage::testAllInfolists($appRoot, $ns);
    });

    test('all resources expose model and pages', function (): void {
        [$appRoot, $ns] = jobFilamentContext();
        FilamentSchemaCoverage::testAllResources($appRoot, $ns);
    });

    test('all list pages expose table columns', function (): void {
        [$appRoot, $ns] = jobFilamentContext();
        FilamentSchemaCoverage::testAllListPages($appRoot, $ns);
    });
});

describe('Job enum and provider coverage', function (): void {
    test('enums expose cases and labels', function (): void {
        [$appRoot, $ns] = jobFilamentContext();
        $enumDir = $appRoot.'/Enums';
        Assert::assertDirectoryExists($enumDir);
        foreach (jobPhpFiles($enumDir.'/*.php') as $file) {
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
        }
    });

    test('service providers declare module name', function (): void {
        [$appRoot, $ns] = jobFilamentContext();
        foreach (jobPhpFiles($appRoot.'/Providers/*ServiceProvider.php') as $file) {
            $class = $ns.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen($appRoot) + 1));
            if (! class_exists($class)) {
                continue;
            }
            $provider = new $class(app());
            if (property_exists($provider, 'name')) {
                Assert::assertIsString($provider->name);
                Assert::assertNotSame('', $provider->name);
            }
        }
    });
});
