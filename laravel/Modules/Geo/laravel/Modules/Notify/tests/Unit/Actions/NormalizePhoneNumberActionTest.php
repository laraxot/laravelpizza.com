<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;

use Modules\Notify\Actions\NormalizePhoneNumberAction;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_uses;

uses(TestCase::class);

describe('NormalizePhoneNumberAction', function () {
    it('can be instantiated', function () {
        Assert::assertTrue(class_exists(NormalizePhoneNumberAction::class));
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(NormalizePhoneNumberAction::class);
        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(NormalizePhoneNumberAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(1, $method->getNumberOfParameters());
    });

    it('execute accepts nullable string parameter', function () {
        $reflection = new \ReflectionClass(NormalizePhoneNumberAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        Assert::assertStringContainsString((string) 'string', (string) $params[0]->getType());
    });

    it('execute returns string', function () {
        $reflection = new \ReflectionClass(NormalizePhoneNumberAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        \assertReflectionTypeName($returnType, 'string');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(NormalizePhoneNumberAction::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(NormalizePhoneNumberAction::class);

        Assert::assertSame('Modules\Notify\Actions', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = \notifyReflectionSource(new \ReflectionClass(NormalizePhoneNumberAction::class));

        Assert::assertStringContainsString('use Modules\Xot\Actions\Cast\SafeStringCastAction', $content);
        Assert::assertStringContainsString('use Spatie\QueueableAction\QueueableAction', $content);
    });

    it('implements queueable functionality', function () {
        $reflection = new \ReflectionClass(NormalizePhoneNumberAction::class);
        Assert::assertTrue($reflection->hasMethod('onQueue'));
    });
});
