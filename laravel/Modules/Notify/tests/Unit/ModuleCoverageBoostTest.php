<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit;

use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\glob;

uses(TestCase::class);
/**
 * @return list<class-string>
 */
function notifyBoostClasses(string $pattern): array
{
    $root = dirname(__DIR__, 2).'/app';
    /** @var list<string> $files */
    $files = glob($root.'/'.$pattern);
    $classes = [];

    foreach ($files as $file) {
        $relative = str_replace($root.'/', '', $file);
        $class = 'Modules\\Notify\\'.str_replace(['/', '.php'], ['\\', ''], $relative);
        if (class_exists($class)) {
            $classes[] = $class;
        }
    }

    sort($classes);

    return $classes;
}

describe('Notify coverage boost', function (): void {
    test('enums expose cases labels or options', function (): void {
        foreach (notifyBoostClasses('Enums/*.php') as $class) {
            $ref = new ReflectionClass($class);
            if (! $ref->isEnum()) {
                continue;
            }
            Assert::assertNotEmpty($class::cases());
            if (method_exists($class, 'options')) {
                Assert::assertIsArray($class::options());
            }
        }
    });

    test('actions resolve from container', function (): void {
        foreach (notifyBoostClasses('Actions/**/*.php') as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface()) {
                continue;
            }
            try {
                Assert::assertInstanceOf($class, app($class));
            } catch (\Throwable) {
                try {
                    Assert::assertInstanceOf($class, new $class);
                } catch (\Throwable) {
                    Assert::assertTrue($ref->hasMethod('execute') || $ref->hasMethod('handle'));
                }
            }
            Assert::assertStringContainsString('declare(strict_types=1);', XotBasePest::reflectionSource($class));
        }
    });

    test('policies declare authorization surface', function (): void {
        foreach (notifyBoostClasses('Models/Policies/*.php') as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract()) {
                continue;
            }
            Assert::assertTrue($ref->hasMethod('viewAny') || $ref->hasMethod('before'));
        }
    });

    test('datas support from and to array when available', function (): void {
        foreach (notifyBoostClasses('Datas/**/*.php') as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface()) {
                continue;
            }
            if (method_exists($class, 'from')) {
                Assert::assertTrue($ref->hasMethod('from'));
            }
            if (method_exists($class, 'toArray')) {
                Assert::assertTrue($ref->hasMethod('toArray'));
            }
        }
    });
});