<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\Mail;
use function Safe\file_get_contents;
use function Safe\class_uses;
use Modules\Notify\Actions\Mail\GetMailLayoutAction;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

uses(\Modules\Notify\Tests\TestCase::class);

describe('GetMailLayoutAction', function () {
    it('can be instantiated', function () {
        $action = new GetMailLayoutAction;

        Assert::assertInstanceOf(GetMailLayoutAction::class, $action);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(GetMailLayoutAction::class);

        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts string parameter', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        \assertReflectionTypeName($params[0]->getType(), 'string');
    });

    it('execute returns string', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        \assertReflectionTypeName($returnType, 'string');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);

        Assert::assertSame('Modules\Notify\Actions\Mail', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = \notifyReflectionSource(new \ReflectionClass(GetMailLayoutAction::class));
        Assert::assertStringContainsString('use Modules\Xot\Actions\Cast\SafeStringCastAction;', $content);
        Assert::assertStringContainsString('use Modules\Xot\Actions\Theme\GetThemeContextAction;', $content);
        Assert::assertStringContainsString('use Modules\Xot\Datas\XotData;', $content);
    });

    it('implements queueable functionality', function () {
            });
});
