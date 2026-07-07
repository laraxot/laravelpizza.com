<?php

declare(strict_types=1);
use Modules\Job\Actions\GetTaskFrequenciesAction;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;
use function Safe\file_get_contents;

uses(TestCase::class);

describe('GetTaskFrequenciesAction', function (): void {
    test('can be instantiated', function (): void {
        $action = new GetTaskFrequenciesAction;
        Assert::assertInstanceOf(GetTaskFrequenciesAction::class, $action);
    });

    test('has queueable action trait', function (): void {
        $traits = class_uses(GetTaskFrequenciesAction::class);
        Assert::assertContains('Spatie\QueueableAction\QueueableAction', $traits);
    });

    test('has correct method signature', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertInstanceOf(ReflectionNamedType::class, $returnType = $method->getReturnType());
        Assert::assertSame('array', $returnType->getName());
        Assert::assertSame(0, $method->getNumberOfParameters());
    });

    test('has proper return type annotation', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        $method = $reflection->getMethod('execute');
        $docComment = $method->getDocComment();

        Assert::assertIsString($docComment);
        Assert::assertStringContainsString('@return array', $docComment);
    });

    test('has proper class structure', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        Assert::assertTrue($reflection->isInstantiable());
        Assert::assertFalse($reflection->isFinal());
        Assert::assertFalse($reflection->isAbstract());
    });

    test('has correct namespace', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        Assert::assertSame('Modules\Job\Actions', $reflection->getNamespaceName());
    });

    test('uses strict types', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('', $content);
    });

    test('has proper imports', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('use Exception;', $content);
        Assert::assertStringContainsString('use Spatie\QueueableAction\QueueableAction;', $content);
    });

    test('validates class dependencies', function (): void {
        Assert::assertTrue(class_exists('Exception'));
        Assert::assertTrue(trait_exists('Spatie\QueueableAction\QueueableAction'));
    });

    test('has correct method implementation structure', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        $method = $reflection->getMethod('execute');
        Assert::assertTrue($method->isPublic());
        Assert::assertFalse($method->isStatic());
        Assert::assertFalse($method->isAbstract());
    });

    test('can be used with dependency injection', function (): void {
        $actionFromContainer = app(GetTaskFrequenciesAction::class);
        Assert::assertInstanceOf(GetTaskFrequenciesAction::class, $actionFromContainer);
    });

    test('has proper error handling implementation', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('throw new Exception', $content);
    });

    test('validates config function usage', function (): void {
        $reflection = new ReflectionClass(GetTaskFrequenciesAction::class);
        $filename = $reflection->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('config(', $content);
    });
});
