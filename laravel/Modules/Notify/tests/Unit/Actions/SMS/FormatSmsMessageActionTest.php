<?php

declare(strict_types=1);

use Modules\Notify\Actions\SMS\FormatSmsMessageAction;

describe('FormatSmsMessageAction', function () {
    beforeEach(function () {
        // @var mixed action = new FormatSmsMessageAction;
    });

    it('can be instantiated', function () {
        expect(// @var mixed action;
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts string parameter', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe('string');
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
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

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\SMS');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(// @var mixed action;
        $content = file_get_contents($filename);

        expect($content)->toContain('use function Safe\preg_split;');
    });

    it('is not using QueueableAction trait', function () {
        $traits = class_uses(// @var mixed action;

        expect($traits)->not->toContain('Spatie\QueueableAction\QueueableAction');
    });
});
