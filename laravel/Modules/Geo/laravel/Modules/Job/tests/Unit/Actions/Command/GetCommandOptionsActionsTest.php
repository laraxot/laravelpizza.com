<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Actions\Command;
use function Safe\class_uses;
use Modules\Job\Actions\Command\GetCommandOptionsActions;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Command\Command;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('GetCommandOptionsActions', function (): void {
    test('can be instantiated', function (): void {
        $action = new GetCommandOptionsActions;
        Assert::assertInstanceOf(GetCommandOptionsActions::class, $action);
    });

    test('has correct method signature', function (): void {
        $reflection = new \ReflectionClass(GetCommandOptionsActions::class);
        $method = $reflection->getMethod('execute');
        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    test('returns array with structure', function (): void {
        $action = new GetCommandOptionsActions;
        $command = new Command('test');
        $result = $action->execute($command);

        Assert::assertArrayHasKey('withValue', $result);
        Assert::assertArrayHasKey('withoutValue', $result);
    });

    test('includes default options in withoutValue', function (): void {
        $action = new GetCommandOptionsActions;
        $command = new Command('test');
        $result = $action->execute($command);

        Assert::assertContains('verbose', $result['withoutValue']);
        Assert::assertContains('quiet', $result['withoutValue']);
        Assert::assertContains('ansi', $result['withoutValue']);
        Assert::assertContains('no-ansi', $result['withoutValue']);
    });

    test('uses strict types', function (): void {
        $reflection = new \ReflectionClass(GetCommandOptionsActions::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('has correct namespace', function (): void {
        $reflection = new \ReflectionClass(GetCommandOptionsActions::class);
        Assert::assertSame('Modules\Job\Actions\Command', $reflection->getNamespaceName());
    });

    test('uses QueueableAction trait', function (): void {
        $traits = class_uses(GetCommandOptionsActions::class);
        Assert::assertContains('Spatie\QueueableAction\QueueableAction', $traits);
    });

    test('has proper class structure', function (): void {
        $reflection = new \ReflectionClass(GetCommandOptionsActions::class);
        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertFalse($reflection->isFinal());
        Assert::assertFalse($reflection->isAbstract());
    });

    test('implements queueable functionality', function (): void {
        $reflection = new \ReflectionClass(GetCommandOptionsActions::class);
        Assert::assertTrue($reflection->hasMethod('onQueue'));
    });

    test('has required imports', function (): void {
        $reflection = new \ReflectionClass(GetCommandOptionsActions::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('', $content);
    });
});
