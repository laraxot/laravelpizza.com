<?php

declare(strict_types=1);

use Modules\Job\Actions\DummyAction;

describe('DummyAction', function () {
    beforeEach(function () {
        // @var mixed action = new DummyAction;
    });

    it('can be instantiated', function () {
        expect(// @var mixed action;
    });

    it('has correct method signature', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->getNumberOfParameters())
            ->toBe(0)
            ->and($method->getReturnType()?->getName())
            ->toBe('void');
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(// @var mixed action;

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(// @var mixed action;

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Actions');
    });

    it('has proper class structure', function () {
        $reflection = new ReflectionClass(// @var mixed action;

        expect($reflection->isInstantiable())
            ->toBeTrue()
            ->and($reflection->isFinal())
            ->toBeFalse()
            ->and($reflection->isAbstract())
            ->toBeFalse();
    });

    it('implements queueable functionality', function () {
        expect(method_exists(// @var mixed action, 'onQueue';
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(// @var mixed action;
        $content = file_get_contents($filename);

        expect($content)->toContain('use Spatie\QueueableAction\QueueableAction;');
    });
});
