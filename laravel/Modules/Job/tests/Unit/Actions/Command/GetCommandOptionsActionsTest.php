<?php

declare(strict_types=1);

use Modules\Job\Actions\Command\GetCommandOptionsActions;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

describe('GetCommandOptionsActions', function () {
    beforeEach(function () {
        $this->action = new GetCommandOptionsActions;
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(GetCommandOptionsActions::class);
    });

    it('has correct method signature', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())
            ->toBeTrue()
            ->and($method->getNumberOfParameters())
            ->toBe(1);
    });

    it('returns array with structure', function () {
        // Create a mock command for testing
        $command = new Command('test');
        $result = $this->action->execute($command);

        expect($result)->toBeArray()
            ->toHaveKey('withValue')
            ->toHaveKey('withoutValue');
    });

    it('includes default options in withoutValue', function () {
        $command = new Command('test');
        $result = $this->action->execute($command);

        expect($result['withoutValue'])->toContain('verbose')
            ->toContain('quiet')
            ->toContain('ansi')
            ->toContain('no-ansi');
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
