<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\Mail;

use Modules\Notify\Actions\Mail\GetMailLayoutAction;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_uses;

uses(\Modules\Notify\Tests\TestCase::class);
describe('GetMailLayoutAction', function () {
    it('can be instantiated', function () {
        Assert::assertSame(
            'Modules\\Notify\\Actions\\Mail',
            (new \ReflectionClass(GetMailLayoutAction::class))->getNamespaceName(),
        );
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

        XotBasePest::assertReflectionTypeName($params[0]->getType(), 'string');
    });

    it('execute returns string', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        XotBasePest::assertReflectionTypeName($returnType, 'string');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);
        $content = TestCase::notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(GetMailLayoutAction::class);

        Assert::assertSame('Modules\Notify\Actions\Mail', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = TestCase::notifyReflectionSource(new \ReflectionClass(GetMailLayoutAction::class));
        Assert::assertStringContainsString('use Modules\Xot\Actions\Cast\SafeStringCastAction;', $content);
        Assert::assertStringContainsString('use Modules\Xot\Actions\Theme\GetThemeContextAction;', $content);
        Assert::assertStringContainsString('use Modules\Xot\Datas\XotData;', $content);
    });

    it('implements queueable functionality', function () {
        $traits = class_uses(GetMailLayoutAction::class);

        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });
});