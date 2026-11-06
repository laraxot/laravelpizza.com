<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;

use Modules\Job\Events\Event;
use Modules\Job\Events\TaskEvent;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;
use function Safe\file_get_contents;

uses(TestCase::class);

describe('TaskEvent', function () {
    it('extends Event base class', function () {
        Assert::assertTrue((new \ReflectionClass(TaskEvent::class))->isSubclassOf(Event::class));
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(TaskEvent::class);

        Assert::assertSame('Modules\Job\Events', $reflection->getNamespaceName());
    });

    it('uses Dispatchable and SerializesModels traits', function () {
        $traits = class_uses(TaskEvent::class);

        Assert::assertContains('Illuminate\Foundation\Events\Dispatchable', $traits);
        Assert::assertContains('Illuminate\Queue\SerializesModels', $traits);
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(TaskEvent::class);
        $filename = $reflection->getFileName();

        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1)', $content);
    });

    it('has Task property', function () {
        $reflection = new \ReflectionClass(TaskEvent::class);
        $props = $reflection->getProperties();

        Assert::assertCount(1, $props);
        Assert::assertSame('task', $props[0]->getName());
        Assert::assertSame('Modules\Job\Models\Task', ($t0 = $props[0]->getType()) instanceof \ReflectionNamedType ? $t0->getName() : null);
    });

    it('has required imports', function () {
        $filename = (new \ReflectionClass(TaskEvent::class))->getFileName();
        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);

        Assert::assertStringContainsString('use Illuminate\Foundation\Events\Dispatchable;', $content);
        Assert::assertStringContainsString('use Illuminate\Queue\SerializesModels;', $content);
        Assert::assertStringContainsString('use Modules\Job\Models\Task;', $content);
    });
});
