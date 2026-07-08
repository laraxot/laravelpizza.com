<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit\Events;
use Modules\Job\Events\BroadcastingEvent;
use Modules\Job\Events\Executing;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\file_get_contents;

uses(\Modules\Job\Tests\TestCase::class);

describe('Executing', function () {
    it('extends BroadcastingEvent', function () {
        Assert::assertTrue((new \ReflectionClass(Executing::class))->isSubclassOf(BroadcastingEvent::class));
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(Executing::class);

        Assert::assertSame('Modules\Job\Events', $reflection->getNamespaceName());
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(Executing::class);
        $filename = $reflection->getFileName();

        Assert::assertNotFalse($filename);
        $content = file_get_contents($filename);
        Assert::assertStringContainsString('declare(strict_types=1);', $content);
    });

    it('is instantiable', function () {
        $reflection = new \ReflectionClass(Executing::class);

        Assert::assertTrue($reflection->isInstantiable());
    });

    it('has no additional methods', function () {
        $reflection = new \ReflectionClass(Executing::class);
        $ownMethods = array_filter(
            $reflection->getMethods(\ReflectionMethod::IS_PUBLIC),
            static fn (\ReflectionMethod $method): bool => $method->getDeclaringClass()->getName() === Executing::class,
        );

        Assert::assertSame([], array_values($ownMethods));
    });
});
