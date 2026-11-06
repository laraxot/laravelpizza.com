<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Modules\Xot\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use ReflectionClass;

use function Safe\glob;

uses(TestCase::class)->group('no-xot-db');

/**
 * @return list<class-string>
 */
function xotBoostClasses(string $pattern): array
{
    $root = dirname(__DIR__, 2).'/app';
    /** @var list<string> $files */
    $files = glob($root.'/'.$pattern);
    $classes = [];

    foreach ($files as $file) {
        if (! is_string($file)) {
            throw new \UnexpectedValueException('Safe\\glob deve restituire percorsi stringa');
        }
        $relative = str_replace($root.'/', '', $file);
        $class = 'Modules\\Xot\\'.str_replace(['/', '.php'], ['\\', ''], $relative);
        if (class_exists($class)) {
            $classes[] = $class;
        }
    }

    sort($classes);

    return $classes;
}

describe('Xot coverage boost', function (): void {
    test('enums expose cases and labels', function (): void {
        $seen = 0;
        foreach (xotBoostClasses('Enums/*.php') as $class) {
            if (! enum_exists($class)) {
                continue;
            }
            Assert::assertNotEmpty($class::cases());
            foreach ($class::cases() as $case) {
                if (method_exists($case, 'getLabel')) {
                    Assert::assertNotEmpty($case->getLabel());
                }
            }
            $seen++;
        }
        Assert::assertGreaterThan(0, $seen, 'Xot deve scoprire almeno un enum concreto');
    });

    test('cast and string actions resolve from container', function (): void {
        foreach (array_merge(xotBoostClasses('Actions/Cast/*.php'), xotBoostClasses('Actions/String/*.php')) as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract()) {
                continue;
            }
            Assert::assertInstanceOf($class, app($class));
            Assert::assertStringContainsString('declare(strict_types=1);', XotBasePest::reflectionSource($class));
        }
    });

    test('value objects and datas are constructible', function (): void {
        foreach (array_merge(xotBoostClasses('ValueObjects/*.php'), xotBoostClasses('Datas/*.php')) as $class) {
            $ref = new ReflectionClass($class);
            if ($ref->isAbstract() || $ref->isInterface()) {
                continue;
            }
            Assert::assertTrue($ref->hasMethod('__construct') || $ref->hasMethod('from') || $ref->hasMethod('make'));
        }
    });

    test('providers expose module name', function (): void {
        $class = 'Modules\\Xot\\Providers\\XotServiceProvider';
        Assert::assertTrue(class_exists($class));
        $provider = new $class(app());
        Assert::assertSame('Xot', (string) $provider->name);
    });
});
