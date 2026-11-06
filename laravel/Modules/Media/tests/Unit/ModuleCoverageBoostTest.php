<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit;

use Filament\Support\Contracts\HasLabel;
use Modules\Media\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\glob;

uses(TestCase::class)->group('no-media-db');

/**
 * @return list<class-string>
 */
function mediaBoostClasses(string $pattern): array
{
    $root = dirname(__DIR__, 2).'/app';
    $files = glob($root.'/'.$pattern);
    $classes = [];

    foreach ($files as $file) {
        if (! is_string($file)) {
            continue;
        }
        $relative = str_replace($root.'/', '', $file);
        $class = 'Modules\\Media\\'.str_replace(['/', '.php'], ['\\', ''], $relative);
        if (class_exists($class)) {
            $classes[] = $class;
        }
    }

    sort($classes);

    return $classes;
}

describe('Media coverage boost', function (): void {
    test('enums expose cases and labels or options', function (): void {
        foreach (mediaBoostClasses('Enums/*.php') as $class) {
            if (! enum_exists($class)) {
                continue;
            }
            $cases = $class::cases();
            Assert::assertNotEmpty($cases);
            foreach ($cases as $case) {
                if ($case instanceof HasLabel) {
                    Assert::assertIsString($case->getLabel());
                }
            }
            if (method_exists($class, 'options')) {
                Assert::assertIsArray($class::options());
            }
        }
    });

    test('actions are instantiable and declare strict types', function (): void {
        foreach (mediaBoostClasses('Actions/**/*.php') as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface()) {
                continue;
            }
            Assert::assertInstanceOf($class, app($class));
            Assert::assertStringContainsString('declare(strict_types=1);', XotBasePest::reflectionSource($class));
        }
    });

    test('policies expose authorization methods', function (): void {
        foreach (mediaBoostClasses('Models/Policies/*.php') as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract()) {
                continue;
            }
            Assert::assertTrue($ref->hasMethod('viewAny') || $ref->hasMethod('before'));
        }
    });

    test('providers declare module name', function (): void {
        foreach (mediaBoostClasses('Providers/*ServiceProvider.php') as $class) {
            $provider = new $class(app());
            if (property_exists($provider, 'name')) {
                Assert::assertIsString($provider->name);
                Assert::assertNotSame('', $provider->name);
            }
        }
    });
});
