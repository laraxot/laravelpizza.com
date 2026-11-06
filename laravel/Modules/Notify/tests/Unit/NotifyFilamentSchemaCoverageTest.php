<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\FilamentSchemaCoverage;
use PHPUnit\Framework\Assert;

use function Safe\glob;

uses(TestCase::class);
/**
 * @return array{string, string} radice `app/` del modulo e namespace corrispondente
 */
/** @return list{string, string} */
function notifyFilamentContext(): array
{
    return [dirname(__DIR__, 2).'/app', 'Modules\\Notify\\'];
}

describe('Notify Filament schema coverage', function (): void {
    test('all form schemas execute getFormSchema', function (): void {
        [$appRoot, $ns] = notifyFilamentContext();
        FilamentSchemaCoverage::testAllForms($appRoot, $ns);
        Assert::assertNotEmpty(FilamentSchemaCoverage::discover($appRoot, $ns, 'Form'));
    });

    test('all table classes execute getTableColumns', function (): void {
        [$appRoot, $ns] = notifyFilamentContext();
        FilamentSchemaCoverage::testAllTables($appRoot, $ns);
        Assert::assertNotEmpty(FilamentSchemaCoverage::discover($appRoot, $ns, 'Table'));
    });

    test('all infolist schemas execute getInfolistSchema', function (): void {
        [$appRoot, $ns] = notifyFilamentContext();
        FilamentSchemaCoverage::testAllInfolists($appRoot, $ns);
    });

    test('all resources expose model and pages', function (): void {
        [$appRoot, $ns] = notifyFilamentContext();
        FilamentSchemaCoverage::testAllResources($appRoot, $ns);
    });

    test('all list pages expose table columns', function (): void {
        [$appRoot, $ns] = notifyFilamentContext();
        FilamentSchemaCoverage::testAllListPages($appRoot, $ns);
    });
});

describe('Notify enum and provider coverage', function (): void {
    test('enums expose cases and labels', function (): void {
        [$appRoot, $ns] = notifyFilamentContext();
        foreach (glob($appRoot.'/Enums/*.php') as $file) {
            if (! is_string($file)) {
                continue;
            }
            $class = $ns.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen($appRoot) + 1));
            if (! enum_exists($class)) {
                continue;
            }
            Assert::assertNotEmpty($class::cases());
        }
    });

    test('service providers declare module name', function (): void {
        [$appRoot, $ns] = notifyFilamentContext();
        foreach (glob($appRoot.'/Providers/*ServiceProvider.php') as $file) {
            if (! is_string($file)) {
                continue;
            }
            $class = $ns.str_replace(['/', '.php'], ['\\', ''], substr($file, strlen($appRoot) + 1));
            $provider = new $class(app());
            if (property_exists($provider, 'name')) {
                Assert::assertSame('Notify', $provider->name);
            }
        }
    });
});