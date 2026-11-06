<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\Actions;

use Modules\AI\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use Spatie\QueueableAction\QueueableAction;

uses(TestCase::class);

it('keeps AI actions queueable with execute entrypoints', function (): void {
    $actionsPath = dirname(__DIR__, 3).'/app/Actions';
    $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($actionsPath));
    $classes = [];

    foreach ($iterator as $file) {
        if (! $file instanceof \SplFileInfo || ! $file->isFile() || $file->getExtension() !== 'php') {
            continue;
        }

        $relative = str_replace($actionsPath.'/', '', $file->getPathname());
        $classes[] = 'Modules\\AI\\Actions\\'.str_replace(['/', '.php'], ['\\', ''], $relative);
    }

    Assert::assertNotSame([], $classes);

    foreach ($classes as $class) {
        Assert::assertTrue(class_exists($class), "{$class} must be autoloadable");

        $reflection = new ReflectionClass($class);

        Assert::assertContains(
            QueueableAction::class,
            $reflection->getTraitNames(),
            "{$class} must use QueueableAction",
        );
        Assert::assertTrue($reflection->hasMethod('execute'), "{$class} must expose execute()");
        Assert::assertTrue($reflection->getMethod('execute')->isPublic(), "{$class} execute() must be public");
    }
});
