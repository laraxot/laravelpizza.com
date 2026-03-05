<?php

declare(strict_types=1);

use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

describe('NetfunSendAction', function () {
    // Test strutturali senza istanziazione - la classe richiede config() nel costruttore
    it('has correct class definition', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(NetfunSendAction::class);
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe(SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
    });

    it('has token property', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);

        expect($reflection->hasProperty('token'))->toBeTrue();
    });

    it('has vars property', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);

        expect($reflection->hasProperty('vars'))->toBeTrue();
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(NetfunSendAction::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(NetfunSendAction::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use GuzzleHttp\Client;');
        expect($content)->toContain('use Modules\Notify\Datas\SmsData;');
    });
});
