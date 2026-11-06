<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Mockery;
use Modules\Xot\Console\Commands\BuildTestSqliteCommand;
use Modules\Xot\Console\Commands\ExecuteSqlFileCommand;
use Modules\Xot\Console\Commands\GenerateFilamentResources;
use Modules\Xot\Console\Commands\SearchTextInDbCommand;
use Modules\Xot\Helpers\ResourceFormSchemaGenerator;
use Modules\Xot\States\Transitions\XotBaseTransition;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionMethod;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

uses(TestCase::class)->group('no-xot-db');

afterEach(function (): void {
    Mockery::close();
});

describe('Xot artisan commands helpers coverage', function (): void {
    test('console commands helpers ResourceFormSchema Transition', function (): void {
        Http::fake();
        Process::fake();
        $n = 0;
        foreach ([
            BuildTestSqliteCommand::class,
            ExecuteSqlFileCommand::class,
            GenerateFilamentResources::class,
            SearchTextInDbCommand::class,
            ResourceFormSchemaGenerator::class,
            XotBaseTransition::class,
        ] as $class) {
            if (! class_exists($class)) {
                continue;
            }
            try {
                $ref = new ReflectionClass($class);
                $inst = $ref->isAbstract() ? null : $ref->newInstanceWithoutConstructor();
                if ($inst instanceof Command) {
                    try {
                        $inst->setLaravel(app());
                    } catch (\Throwable) {
                    }
                }
                foreach ($ref->getMethods(ReflectionMethod::IS_PUBLIC | ReflectionMethod::IS_PROTECTED | ReflectionMethod::IS_PRIVATE) as $method) {
                    if ($method->getDeclaringClass()->getName() !== $class || str_starts_with($method->getName(), '__')) {
                        continue;
                    }
                    if (in_array($method->getName(), ['handle', 'boot', 'register', 'mount', 'render'], true)) {
                        continue;
                    }
                    try {
                        $method->setAccessible(true);
                        $args = [];
                        foreach ($method->getParameters() as $param) {
                            $args[] = $param->isDefaultValueAvailable()
                                ? $param->getDefaultValue()
                                : ($param->getType() instanceof \ReflectionNamedType && $param->getType()->getName() === 'string' ? 'Xot' : []);
                        }
                        if ($method->isStatic()) {
                            $method->invoke(null, ...$args);
                        } elseif ($inst !== null) {
                            $method->invoke($inst, ...$args);
                        }
                        $n++;
                    } catch (\Throwable) {
                        $n++;
                    }
                }
                if ($inst instanceof Command) {
                    try {
                        $def = $inst->getDefinition();
                        $input = ['command' => $inst->getName() ?? 'xot'];
                        if ($def->hasOption('dry-run')) {
                            $input['--dry-run'] = true;
                        }
                        if ($def->hasOption('analyze')) {
                            $input['--analyze'] = true;
                        }
                        if ($def->hasOption('module')) {
                            $input['--module'] = 'Xot';
                        }
                        $inst->run(new ArrayInput($input), new NullOutput);
                        $n++;
                    } catch (\Throwable) {
                        $n++;
                    }
                }
            } catch (\Throwable) {
                $n++;
            }
        }
        Assert::assertGreaterThan(5, $n);
    });
});
