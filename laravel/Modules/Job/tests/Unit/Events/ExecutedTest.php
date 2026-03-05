<?php

declare(strict_types=1);

use Modules\Job\Events\BroadcastingEvent;
use Modules\Job\Events\Executed;

describe('Executed', function () {
    it('extends BroadcastingEvent', function () {
        expect(is_a(Executed::class, BroadcastingEvent::class, true))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(Executed::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Events');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(Executed::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(Executed::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Job\Models\Task;')
            ->and($content)->toContain('use Modules\Job\Notifications\TaskCompleted;');
    });

    it('has constructor with Task, float and string parameters', function () {
        $reflection = new ReflectionClass(Executed::class);
        $constructor = $reflection->getConstructor();

        expect($constructor)->not->toBeNull();

        $params = $constructor->getParameters();
        expect($params)->toHaveCount(3)
            ->and($params[0]->getName())->toBe('task')
            ->and($params[1]->getName())->toBe('started')
            ->and($params[2]->getName())->toBe('output');
    });

    it('is instantiable', function () {
        $reflection = new ReflectionClass(Executed::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });
});
