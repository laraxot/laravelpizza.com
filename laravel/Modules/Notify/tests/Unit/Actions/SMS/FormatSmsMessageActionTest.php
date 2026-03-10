<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\FormatSmsMessageAction;
use ReflectionClass;

describe('FormatSmsMessageAction', function () {
    beforeEach(function () {
        $this->action = new FormatSmsMessageAction;
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(FormatSmsMessageAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts string parameter', function () {
        $reflection = new \ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe('string');
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        /** @var string $filename */
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass($this->action);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\SMS');
    });

    it('has required imports', function () {
        $reflection = new \ReflectionClass($this->action);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        /** @var string $filename */
        $content = file_get_contents($filename);

        expect($content)->toContain('use function Safe\preg_split;');
    });

    it('is not using QueueableAction trait', function () {
        $traits = class_uses($this->action);

        expect($traits)->not->toContain('Spatie\QueueableAction\QueueableAction');
    });
});
