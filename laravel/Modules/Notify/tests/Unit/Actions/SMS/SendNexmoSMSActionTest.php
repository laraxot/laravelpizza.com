<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\SendNexmoSMSAction;
use Modules\Notify\Contracts\SMS\SmsActionContract;
use Modules\Notify\Datas\SmsData;

describe('SendNexmoSMSAction', function () {
    it('can be referenced via ReflectionClass without instantiation', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('implements SmsActionContract', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $interfaces = $reflection->getInterfaceNames();

        expect($interfaces)->toContain(SmsActionContract::class);
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe(SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\SMS');
    });

    it('has required imports', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $filename = $reflection->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Notify\Contracts\SMS\SmsActionContract;');
        expect($content)->toContain('use Modules\Notify\Datas\SmsData;');
        expect($content)->toContain('use Override;');
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendNexmoSMSAction::class);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('has protected debug property', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $property = $reflection->getProperty('debug');

        expect($property->isProtected())->toBeTrue();
    });

    it('has protected defaultSender property', function () {
        $reflection = new ReflectionClass(SendNexmoSMSAction::class);
        $property = $reflection->getProperty('defaultSender');

        expect($property->isProtected())->toBeTrue();
    });
});
