<?php

declare(strict_types=1);

use Modules\Notify\Actions\NormalizePhoneNumberAction;
use Spatie\QueueableAction\QueueableAction;

describe('NormalizePhoneNumberAction', function () {
    beforeEach(function () {
        $this->action = new NormalizePhoneNumberAction;
    });

    it('can be instantiated', function () {
        expect($this->action)->toBeInstanceOf(NormalizePhoneNumberAction::class);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses($this->action);
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts nullable string parameter', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect((string) $params[0]->getType())->toContain('string');
    });

    it('execute returns string', function () {
        $reflection = new ReflectionClass($this->action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('string');
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

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass($this->action))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Xot\Actions\Cast\SafeStringCastAction;');
        expect($content)->toContain('use Spatie\QueueableAction\QueueableAction;');
    });

    it('implements queueable functionality', function () {
        expect(method_exists($this->action, 'onQueue'))->toBeTrue();
    });
});
