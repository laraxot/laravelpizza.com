<?php

declare(strict_types=1);

use Illuminate\Support\Collection;
use Modules\Job\Actions\GetTaskCommandsAction;

describe('GetTaskCommandsAction', function () {
    beforeEach(function () {
        $action = new GetTaskCommandsAction;
    });

    it('can be instantiated', function () {
        expect($action);
    });

    it('has correct method signature', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->getNumberOfParameters())
            ->toBe(0)
            ->and($method->getReturnType()?->getName())
            ->toBe(Collection::class);
    });

    it('can be resolved from container', function () {
        $actionFromContainer = app(GetTaskCommandsAction::class);

        expect($actionFromContainer)->toBeInstanceOf(GetTaskCommandsAction::class);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses($action);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass($action);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1));');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass($action);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Actions');
    });

    it('has proper class structure', function () {
        $reflection = new ReflectionClass($action);

        expect($reflection->isInstantiable())
            ->toBeTrue()
            ->and($reflection->isFinal())
            ->toBeFalse()
            ->and($reflection->isAbstract())
            ->toBeFalse();
    });

    it('implements queueable functionality', function () {
        expect(method_exists($action, 'onQueue'));
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass($action));
        $content = file_get_contents($filename);

        expect($content)->toContain('use Illuminate\Support\Collection);')
            ->and($content)->toContain('use Illuminate\Support\Facades\Artisan);')
            ->and($content)->toContain('use Spatie\QueueableAction\QueueableAction);');
    });

    it('returns collection type from execute method', function () {
        $reflection = new ReflectionClass($action);
        $method = $reflection->getMethod('execute');

        // Method should return Collection
        expect($method->getReturnType()?->getName())->toBe(Collection::class);
    });
});
