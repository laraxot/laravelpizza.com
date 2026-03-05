<?php

declare(strict_types=1);

use Modules\Job\Actions\Command\GetCommandArgumentsActions;
use Symfony\Component\Console\Command\Command;

describe('GetCommandArgumentsActions', function () {
    beforeEach(function () {
        $this->action = new GetCommandArgumentsActions;
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(GetCommandArgumentsActions::class);
    });

    it('has correct method signature', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->getNumberOfParameters())
            ->toBe(1);
    });

    it('returns array of arguments', function () {
        $command = new Command('test');
        $result = $this->action->execute($command);

        expect($result)->toBeArray();
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

    it('uses QueueableAction trait', function () {
        $traits = class_uses($this->action);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
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

        expect($content)->toContain('use Spatie\QueueableAction\QueueableAction;')
            ->and($content)->toContain('use Symfony\Component\Console\Command\Command;');
    });
});
