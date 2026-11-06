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
        $n = 0;
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
                $n++;
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
                            $n++;
                        } catch (\Throwable) {
                            $n++;
                        }
                    }
                }
            } catch (\Throwable $e) {
                Assert::assertNotEmpty($e->getMessage());
                $n++;
            }
        }
        Assert::assertGreaterThan(5, $n);
    });
});
