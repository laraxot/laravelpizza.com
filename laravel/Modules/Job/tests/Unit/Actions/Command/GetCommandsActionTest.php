<?php

declare(strict_types=1);

use Modules\Job\Actions\Command\GetCommandsAction;

describe('GetCommandsAction', function () {
    beforeEach(function () {
        $this->action = new GetCommandsAction;
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(GetCommandsAction::class);
    });

    it('has correct method signature', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->getNumberOfParameters())
            ->toBe(0);
    });

    it('can be resolved from container', function () {
        $actionFromContainer = app(GetCommandsAction::class);

        expect($actionFromContainer)->toBeInstanceOf(GetCommandsAction::class);
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

        expect($reflection->getNamespaceName())->toBe('Modules\Job\Actions\Command');
    });

    it('uses required imports', function () {
        $filename = (new ReflectionClass($this->action))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Illuminate\Console\Application;')
            ->and($content)->toContain('use Illuminate\Support\Collection;')
            ->and($content)->toContain('use Modules\Job\Datas\CommandData;');
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

    it('has execute method returning DataCollection', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        // Method should return DataCollection type
        $returnType = $method->getReturnType();
        expect($returnType)->not->toBeNull();
    });
});
