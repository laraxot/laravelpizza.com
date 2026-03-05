<?php

declare(strict_types=1);

use Modules\Job\Actions\ExecuteTaskAction;

describe('ExecuteTaskAction', function () {
    beforeEach(function () {
        $this->action = new ExecuteTaskAction;
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(ExecuteTaskAction::class);
    });

    it('has correct method signature', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->getNumberOfParameters())
            ->toBe(1);

        $params = $method->getParameters();
        expect($params[0]->getName())->toBe('_task_id')
            ->and($params[0]->getType()?->getName())->toBe('string');
    });

    it('returns string', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->getReturnType()?->getName())->toBe('string');
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses($this->action);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass($this->action);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Actions');
    });

    it('has proper class structure', function () {
        $reflection = new ReflectionClass($this->action);

        expect($reflection->isInstantiable())
            ->toBeTrue()
            ->and($reflection->isFinal())
            ->toBeFalse()
            ->and($reflection->isAbstract())
            ->toBeFalse();
    });

    it('implements queueable functionality', function () {
        expect(method_exists($this->action, 'onQueue'))->toBeTrue();
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass($this->action))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Spatie\QueueableAction\QueueableAction;');
    });

    it('has WIP implementation', function () {
        $reflection = new ReflectionClass($this->action);
        $filename = $reflection->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('dddx');
    });
});
