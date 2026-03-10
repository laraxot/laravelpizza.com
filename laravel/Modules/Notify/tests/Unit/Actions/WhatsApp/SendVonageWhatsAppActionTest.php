<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\WhatsApp;

use Modules\Notify\Actions\WhatsApp\SendVonageWhatsAppAction;
use Modules\Notify\Datas\WhatsAppData;

describe('SendVonageWhatsAppAction', function () {
    it('can be referenced via ReflectionClass without instantiation', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts WhatsAppData parameter', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe(WhatsAppData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('');
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\WhatsApp');
    });

    it('has required imports', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        $filename = $reflection->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Notify\Datas\WhatsAppData;');
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendVonageWhatsAppAction::class);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('has protected debug property', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        $property = $reflection->getProperty('debug');

        expect($property->isProtected())->toBeTrue();
    });

    it('has protected timeout property', function () {
        $reflection = new \ReflectionClass(SendVonageWhatsAppAction::class);
        $property = $reflection->getProperty('timeout');

        expect($property->isProtected())->toBeTrue();
    });
});
