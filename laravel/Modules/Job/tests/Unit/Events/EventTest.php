<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;

use Modules\Job\Events\Event;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;
use function Safe\file_get_contents;

uses(TestCase::class);

describe('Event', function () {

    it('uses Dispatchable trait', function () {
        $traits = class_uses(Event::class);

        Assert::assertContains('Illuminate\Foundation\Events\Dispatchable', $traits);
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(Event::class);
        $filename = $reflection->getFileName();

        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(Event::class);

        Assert::assertSame('Modules\Job\Events', $reflection->getNamespaceName());
    });

    it('has required imports', function () {
        $filename = (new \ReflectionClass(Event::class))->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);

        Assert::assertStringContainsString('use Illuminate\Foundation\Events\Dispatchable;', $content);
    });
});
