<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Actions;

use Modules\Job\Actions\DummyAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;
use function Safe\file_get_contents;

uses(TestCase::class);

describe('DummyAction', function (): void {

    test('has correct method signature', function (): void {
        $reflection = new \ReflectionClass(DummyAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(0, $method->getNumberOfParameters());
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame('void', $returnType->getName());
    });

    test('uses QueueableAction trait', function (): void {
        $traits = class_uses(DummyAction::class);
        Assert::assertContains('Spatie\QueueableAction\QueueableAction', $traits);
    });

    test('uses strict types', function (): void {
        $reflection = new \ReflectionClass(DummyAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('has correct namespace', function (): void {
        $reflection = new \ReflectionClass(DummyAction::class);
        Assert::assertSame('Modules\Job\Actions', $reflection->getNamespaceName());
    });

    test('has proper class structure', function (): void {
        $reflection = new \ReflectionClass(DummyAction::class);
        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertFalse($reflection->isFinal());
        Assert::assertFalse($reflection->isAbstract());
    });

    test('has required imports', function (): void {
        $reflection = new \ReflectionClass(DummyAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('use Spatie\QueueableAction\QueueableAction;', $content);
    });
});
