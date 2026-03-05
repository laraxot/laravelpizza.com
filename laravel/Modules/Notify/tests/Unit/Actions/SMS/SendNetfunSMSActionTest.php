<?php

declare(strict_types=1);

use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;
use Spatie\QueueableAction\QueueableAction;

describe('SendNetfunSMSAction', function () {
    // Test strutturali - la classe richiede config() nel costruttore
    it('has correct class definition', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);

        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('implements SmsActionContract', function () {
        $interfaces = class_implements(SendNetfunSMSAction::class);

        expect($interfaces)->toContain(SmsActionContract::class);
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendNetfunSMSAction::class);
        expect($traits)->toContain(QueueableAction::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe(SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
    });

    it('has required properties', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);

        expect($reflection->hasProperty('debug'))->toBeTrue();
        expect($reflection->hasProperty('timeout'))->toBeTrue();
        expect($reflection->hasProperty('defaultSender'))->toBeTrue();
        expect($reflection->hasProperty('token'))->toBeTrue();
        expect($reflection->hasProperty('endpoint'))->toBeTrue();
        expect($reflection->hasProperty('vars'))->toBeTrue();
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\SMS');
    });

    it('has required imports', function () {
        $filename = (new ReflectionClass(SendNetfunSMSAction::class))->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use GuzzleHttp\Client;');
        expect($content)->toContain('use GuzzleHttp\Exception\ClientException;');
        expect($content)->toContain('use Modules\Notify\Datas\SmsData;');
        expect($content)->toContain('use Override;');
    });

    it('is final class', function () {
        $reflection = new ReflectionClass(SendNetfunSMSAction::class);

        expect($reflection->isFinal())->toBeTrue();
    });
});
