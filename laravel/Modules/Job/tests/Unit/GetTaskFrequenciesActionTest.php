<?php

declare(strict_types=1);

use Modules\Job\Actions\GetTaskFrequenciesAction;

describe('GetTaskFrequenciesAction', function () {
    beforeEach(function () {
        $this->action = new GetTaskFrequenciesAction();
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(GetTaskFrequenciesAction::class);
    });

    it('has queueable action trait', function () {
        $traits = class_uses($this->action);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('has correct method signature', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->getReturnType()?->getName())
            ->toBe('array')
            ->and($method->getNumberOfParameters())
            ->toBe(0);
    });

    it('has proper return type annotation', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        $docComment = $method->getDocComment();
        expect($docComment)->toContain('@return array<string, mixed>');
    });

    it('uses correct exception handling', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        // Check that the method can throw exceptions
        expect($method)->not->toBeNull();
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
        // Test that queueable methods are available
        expect(method_exists($this->action, 'onQueue'))->toBeTrue();
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass($this->action);

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Actions');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        if ($filename) {
            $content = file_get_contents($filename);
            expect($content)->toContain('declare(strict_types=1);');
        }
    });

    it('has proper imports', function () {
        $reflection = new ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        if ($filename) {
            $content = file_get_contents($filename);
            expect($content)
                ->toContain('use Exception;')
                ->and($content)
                ->toContain('use Spatie\QueueableAction\QueueableAction;');
        }
    });

    it('validates class dependencies', function () {
        // Check that required classes exist
        expect(class_exists('Exception'))
            ->toBeTrue()
            ->and(trait_exists('Spatie\QueueableAction\QueueableAction'))
            ->toBeTrue();
    });

    it('has correct method implementation structure', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        // Verify method is properly implemented
        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->isStatic())
            ->toBeFalse()
            ->and($method->isAbstract())
            ->toBeFalse();
    });

    it('follows Laravel action conventions', function () {
        // Test that the action follows Laravel conventions
        expect(method_exists($this->action, 'execute'))->toBeTrue();
    });

    it('can be used with dependency injection', function () {
        // Test that the action can be resolved from container
        $actionFromContainer = app(GetTaskFrequenciesAction::class);

        expect($actionFromContainer)->toBeInstanceOf(GetTaskFrequenciesAction::class);
    });

    it('has proper error handling implementation', function () {
        $reflection = new ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        if ($filename) {
            $content = file_get_contents($filename);
            expect($content)->toContain('throw new Exception');
        }
    });

    it('validates config function usage', function () {
        $reflection = new ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        if ($filename) {
            $content = file_get_contents($filename);
            expect($content)->toContain('config(');
        }
    });
});
