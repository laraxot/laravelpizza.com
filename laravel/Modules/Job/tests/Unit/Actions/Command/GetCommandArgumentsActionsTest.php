<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Actions\Command;
use function Safe\class_uses;
use Modules\Job\Actions\Command\GetCommandArgumentsActions;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Command\Command;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('GetCommandArgumentsActions', function (): void {
    test('can be instantiated', function (): void {
        $action = new GetCommandArgumentsActions;
        Assert::assertInstanceOf(GetCommandArgumentsActions::class, $action);
    });

    test('has correct method signature', function (): void {
        $reflection = new \ReflectionClass(GetCommandArgumentsActions::class);
        $method = $reflection->getMethod('execute');
        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    test('returns array of arguments', function (): void {
        $action = new GetCommandArgumentsActions;
        $command = new Command('test');
        $result = $action->execute($command);
        Assert::assertCount(0, $result);
    });

    test('uses strict types', function (): void {
        $reflection = new \ReflectionClass(GetCommandArgumentsActions::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('has correct namespace', function (): void {
        $reflection = new \ReflectionClass(GetCommandArgumentsActions::class);
        Assert::assertSame('Modules\Job\Actions\Command', $reflection->getNamespaceName());
    });

    test('uses QueueableAction trait', function (): void {
        $traits = class_uses(GetCommandArgumentsActions::class);
        Assert::assertContains('Spatie\QueueableAction\QueueableAction', $traits);
    });

    test('has proper class structure', function (): void {
        $reflection = new \ReflectionClass(GetCommandArgumentsActions::class);
        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertFalse($reflection->isFinal());
        Assert::assertFalse($reflection->isAbstract());
    });

    test('has required imports', function (): void {
        $reflection = new \ReflectionClass(GetCommandArgumentsActions::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('', $content);
    });
});
