<?php

declare(strict_types=1);

use Modules\Job\Events\Event;
use Modules\Job\Events\TaskEvent;

describe('TaskEvent', function () {
    it('extends Event base class', function () {
        expect(is_a(TaskEvent::class, Event::class, true))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(TaskEvent::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Events');
    });

    it('uses Dispatchable and SerializesModels traits', function () {
        $traits = class_uses(TaskEvent::class);

        expect($traits)->toContain('Illuminate\Foundation\Events\Dispatchable')
            ->and($traits)->toContain('Illuminate\Queue\SerializesModels');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(TaskEvent::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has Task property', function () {
        $reflection = new ReflectionClass(TaskEvent::class);
        $props = $reflection->getProperties();

        expect($props)->toHaveCount(1)
            ->and($props[0]->getName())->toBe('task')
            ->and($props[0]->getType()?->getName())->toBe('Modules\Job\Models\Task');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(TaskEvent::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Illuminate\Foundation\Events\Dispatchable;')
            ->and($content)->toContain('use Illuminate\Queue\SerializesModels;')
            ->and($content)->toContain('use Modules\Job\Models\Task;');
    });
});
