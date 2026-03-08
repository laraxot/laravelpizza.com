<?php

declare(strict_types=1);

use Modules\Notify\Actions\EsendexSendAction;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

describe('EsendexSendAction', function () {
    beforeEach(function () {
        // @var mixed action = new EsendexSendAction;
    });

    it('can be instantiated', function () {
        expect(// @var mixed action;
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(// @var mixed action;
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe(SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
    });

    it('has login method', function () {
        $reflection = new ReflectionClass(// @var mixed action;
        $method = $reflection->getMethod('login');

        expect($method->isPublic())->toBeTrue();
    });

    it('has base_endpoint property', function () {
        $reflection = new ReflectionClass(// @var mixed action;

        expect($reflection->hasProperty('base_endpoint'))->toBeTrue();
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

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(// @var mixed action;
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Notify\Datas\SmsData;');
        expect($content)->toContain('use Spatie\QueueableAction\QueueableAction;');
        expect($content)->toContain('use Webmozart\Assert\Assert;');
    });
});
