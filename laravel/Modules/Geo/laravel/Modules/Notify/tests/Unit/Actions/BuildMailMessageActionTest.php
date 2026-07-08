<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;
use Modules\Notify\Tests\TestCase;
use function Safe\file_get_contents;
use function Safe\class_uses;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Notify\Actions\BuildMailMessageAction;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

uses(\Modules\Notify\Tests\TestCase::class);

describe('BuildMailMessageAction', function () {
    // Test strutturali - non richiede container per la classe
    it('has correct class definition', function () {
        $reflection = new \ReflectionClass(BuildMailMessageAction::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(BuildMailMessageAction::class);
        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(BuildMailMessageAction::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(4, $method->getNumberOfParameters());
    });

    it('has correct return type', function () {
        $reflection = new \ReflectionClass(BuildMailMessageAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        \assertReflectionTypeName($returnType, MailMessage::class);
    });

    it('has private decodeRichText method', function () {
        $reflection = new \ReflectionClass(BuildMailMessageAction::class);
        $method = $reflection->getMethod('decodeRichText');

        Assert::assertTrue($method->isPrivate());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(BuildMailMessageAction::class);
        $content = \notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(BuildMailMessageAction::class);

        Assert::assertSame('Modules\Notify\Actions', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $reflection = new \ReflectionClass(BuildMailMessageAction::class);
        $content = \notifyReflectionSource($reflection);

        Assert::assertStringContainsString('use Modules\Notify\Actions\NotifyTheme\Get;', $content);
        Assert::assertStringContainsString('use Modules\Notify\Datas\AttachmentData;', $content);
        Assert::assertStringContainsString('use Spatie\LaravelData\DataCollection;', $content);
    });

    it('has QueueableAction trait applied correctly', function () {
        // The trait is applied, checking trait methods presence
        $traits = class_uses(BuildMailMessageAction::class);
        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });
});
