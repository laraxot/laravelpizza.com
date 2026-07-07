<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Actions;
use function Safe\class_uses;
use Modules\Job\Actions\ExecuteTaskAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('ExecuteTaskAction', function (): void {
    test('can be instantiated', function (): void {
        $action = new ExecuteTaskAction;
        Assert::assertInstanceOf(ExecuteTaskAction::class, $action);
    });

    test('has correct method signature', function (): void {
        $reflection = new \ReflectionClass(ExecuteTaskAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
        $params = $method->getParameters();
        Assert::assertSame('taskId', $params[0]->getName());
        Assert::assertInstanceOf(\ReflectionNamedType::class, $paramType = $params[0]->getType());
        Assert::assertSame('string', $paramType->getName());
    });

    test('returns string', function (): void {
        $reflection = new \ReflectionClass(ExecuteTaskAction::class);
        $method = $reflection->getMethod('execute');
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame('string', $returnType->getName());
    });

    test('uses QueueableAction trait', function (): void {
        $traits = class_uses(ExecuteTaskAction::class);
        Assert::assertContains('Spatie\QueueableAction\QueueableAction', $traits);
    });

    test('uses strict types', function (): void {
        $reflection = new \ReflectionClass(ExecuteTaskAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('has correct namespace', function (): void {
        $reflection = new \ReflectionClass(ExecuteTaskAction::class);
        Assert::assertSame('Modules\Job\Actions', $reflection->getNamespaceName());
    });

    test('has proper class structure', function (): void {
        $reflection = new \ReflectionClass(ExecuteTaskAction::class);
        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertFalse($reflection->isFinal());
        Assert::assertFalse($reflection->isAbstract());
    });

    test('has required imports', function (): void {
        $reflection = new \ReflectionClass(ExecuteTaskAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('use Spatie\QueueableAction\QueueableAction;', $content);
    });
});
