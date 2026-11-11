<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\NotifyTheme\Attachment;

use Modules\Notify\Actions\NotifyTheme\Attachment\Pdf;
use Modules\Notify\Datas\AttachmentData;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_uses;

uses(TestCase::class);
describe('NotifyTheme\Attachment\Pdf', function () {
    it('can be instantiated', function () {
        Assert::assertTrue(class_exists(Pdf::class));
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(Pdf::class);
        Assert::assertArrayHasKey(QueueableAction::class, $traits);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(Pdf::class);
        $method = $reflection->getMethod('execute');

        Assert::assertTrue($method->isPublic());
        Assert::assertSame(2, $method->getNumberOfParameters());
    });

    it('execute accepts string and array parameters', function () {
        $reflection = new \ReflectionClass(Pdf::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        XotBasePest::assertReflectionTypeName($params[0]->getType(), 'string');
        XotBasePest::assertReflectionTypeName($params[1]->getType(), 'array');
    });

    it('execute returns AttachmentData', function () {
        $reflection = new \ReflectionClass(Pdf::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        XotBasePest::assertReflectionTypeName($returnType, AttachmentData::class);
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(Pdf::class);
        $content = TestCase::notifyReflectionSource($reflection);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(Pdf::class);

        Assert::assertSame('Modules\Notify\Actions\NotifyTheme\Attachment', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $content = TestCase::notifyReflectionSource(new \ReflectionClass(Pdf::class));

        Assert::assertStringContainsString('use Modules\Notify\Actions\NotifyTheme\Get', $content);
        Assert::assertStringContainsString('use Modules\Notify\Datas\AttachmentData', $content);
        Assert::assertStringContainsString('use Modules\Xot\Actions\Html\HtmlToPdfAction', $content);
    });
});
