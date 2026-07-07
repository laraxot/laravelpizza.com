<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Actions;
use function Safe\class_uses;
use Illuminate\Support\Collection;
use Modules\Job\Actions\GetTaskCommandsAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('GetTaskCommandsAction', function (): void {
    test('can be instantiated', function (): void {
        $action = new GetTaskCommandsAction;
        Assert::assertInstanceOf(GetTaskCommandsAction::class, $action);
    });

    test('has correct method signature', function (): void {
        $reflection = new \ReflectionClass(GetTaskCommandsAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(0, $method->getNumberOfParameters());
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame(Collection::class, $returnType->getName());
    });

    test('can be resolved from container', function (): void {
        $actionFromContainer = app(GetTaskCommandsAction::class);
        Assert::assertInstanceOf(GetTaskCommandsAction::class, $actionFromContainer);
    });

    test('uses QueueableAction trait', function (): void {
        $traits = class_uses(GetTaskCommandsAction::class);
        Assert::assertContains('Spatie\QueueableAction\QueueableAction', $traits);
    });

    test('uses strict types', function (): void {
        $reflection = new \ReflectionClass(GetTaskCommandsAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('has correct namespace', function (): void {
        $reflection = new \ReflectionClass(GetTaskCommandsAction::class);
        Assert::assertSame('Modules\Job\Actions', $reflection->getNamespaceName());
    });

    test('has proper class structure', function (): void {
        $reflection = new \ReflectionClass(GetTaskCommandsAction::class);
        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertFalse($reflection->isFinal());
        Assert::assertFalse($reflection->isAbstract());
    });

    test('has required imports', function (): void {
        $reflection = new \ReflectionClass(GetTaskCommandsAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('use Illuminate\Support\Facades\Artisan;', $content);
        Assert::assertStringContainsString('use Spatie\QueueableAction\QueueableAction;', $content);
    });
});
