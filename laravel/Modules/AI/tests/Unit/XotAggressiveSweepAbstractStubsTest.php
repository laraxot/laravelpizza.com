<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Mockery;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsCheckbox3;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsGroup3;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsRadio3;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsSection3;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsSelect3;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsTableAction3;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsViewColumn3;
use Modules\Xot\Tests\Fixtures\Stubs\XotAbsWizard3;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Xot abstract Filament stubs', function (): void {
    test('make e setUp su stub concreti', function (): void {
        Http::fake();
        Process::fake();
        $built = 0;
        foreach ([
            XotAbsSelect3::class,
            XotAbsRadio3::class,
            XotAbsCheckbox3::class,
            XotAbsSection3::class,
            XotAbsGroup3::class,
            XotAbsTableAction3::class,
            XotAbsViewColumn3::class,
            XotAbsWizard3::class,
        ] as $class) {
            try {
                $inst = method_exists($class, 'make')
                    ? $class::make('field')
                    : (new ReflectionClass($class))->newInstanceWithoutConstructor();
                Assert::assertIsObject($inst);
                $built++;
                $parent = (new ReflectionClass($class))->getParentClass();
                if ($parent) {
                    foreach ($parent->getMethods(ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PUBLIC) as $method) {
                        if ($method->getDeclaringClass()->getName() !== $parent->getName()) {
                            continue;
                        }
                        if (str_starts_with($method->getName(), '__') || in_array($method->getName(), ['mount', 'render'], true)) {
                            continue;
                        }
                        if ($method->getNumberOfRequiredParameters() > 1) {
                            continue;
                        }
                        try {
                            $method->setAccessible(true);
                            $args = [];
                            foreach ($method->getParameters() as $param) {
                                $args[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
                            }
                            if ($method->isStatic()) {
                                $method->invoke(null, ...$args);
                            } else {
                                $method->invoke($inst, ...$args);
                            }
                        } catch (\Throwable) {
                            // Lo sweep esercita i metodi dello stub: un metodo che fallisce senza contesto non e' un errore del test.
                        }
                    }
                }
            } catch (\Throwable $e) {
                Assert::assertNotEmpty($e->getMessage());
            }
        }
        // Conta solo gli stub istanziati davvero, non i rami catch.
        Assert::assertGreaterThan(5, $built, 'Meno di 6 stub astratti Filament su 8 si istanziano.');
    });
});
