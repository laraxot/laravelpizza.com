<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Actions\Command;
use Modules\Job\Actions\Command\GetCommandsAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('GetCommandsAction', function (): void {
    test('can be instantiated', function (): void {
        $action = new GetCommandsAction;
        Assert::assertInstanceOf(GetCommandsAction::class, $action);
    });

    test('has correct method signature', function (): void {
        $reflection = new \ReflectionClass(GetCommandsAction::class);
        $method = $reflection->getMethod('execute');
        Assert::assertTrue($method->isPublic());
        Assert::assertSame(0, $method->getNumberOfParameters());
    });

    test('can be resolved from container', function (): void {
        $actionFromContainer = app(GetCommandsAction::class);
        Assert::assertInstanceOf(GetCommandsAction::class, $actionFromContainer);
    });

    test('uses strict types', function (): void {
        $reflection = new \ReflectionClass(GetCommandsAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    test('has correct namespace', function (): void {
        $reflection = new \ReflectionClass(GetCommandsAction::class);
        Assert::assertSame('Modules\Job\Actions\Command', $reflection->getNamespaceName());
    });

    test('uses required imports', function (): void {
        $reflection = new \ReflectionClass(GetCommandsAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('use Illuminate\Support\Collection;', $content);
        Assert::assertStringContainsString('use Modules\Job\Datas\CommandData;', $content);
    });

    test('has proper class structure', function (): void {
        $reflection = new \ReflectionClass(GetCommandsAction::class);
        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertFalse($reflection->isFinal());
        Assert::assertFalse($reflection->isAbstract());
    });

    test('has execute method returning DataCollection', function (): void {
        $reflection = new \ReflectionClass(GetCommandsAction::class);
        $method = $reflection->getMethod('execute');
        Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame(DataCollection::class, $returnType->getName());
    });
});
