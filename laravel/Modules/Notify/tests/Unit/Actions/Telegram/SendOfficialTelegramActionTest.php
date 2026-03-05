<?php

declare(strict_types=1);

use Modules\Notify\Actions\Telegram\SendOfficialTelegramAction;
use Modules\Notify\Datas\TelegramData;

describe('SendOfficialTelegramAction', function () {
    it('can be referenced via ReflectionClass without instantiation', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        expect($reflection->isInstantiable())->toBeTrue();
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts TelegramData parameter', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();

        expect($params[0]->getType()?->getName())->toBe(TelegramData::class);
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType?->getName())->toBe('array');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        $content = file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);

        expect($reflection->getNamespaceName())->toBe('Modules\Notify\Actions\Telegram');
    });

    it('has required imports', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $filename = $reflection->getFileName();
        $content = file_get_contents($filename);

        expect($content)->toContain('use Modules\Notify\Datas\TelegramData;');
    });

    it('uses QueueableAction trait', function () {
        $traits = class_uses(SendOfficialTelegramAction::class);

        expect($traits)->toContain('Spatie\QueueableAction\QueueableAction');
    });

    it('has protected debug property', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $property = $reflection->getProperty('debug');

        expect($property->isProtected())->toBeTrue();
    });

    it('has protected timeout property', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $property = $reflection->getProperty('timeout');

        expect($property->isProtected())->toBeTrue();
    });

    it('has private token property', function () {
        $reflection = new ReflectionClass(SendOfficialTelegramAction::class);
        $property = $reflection->getProperty('token');

        expect($property->isPrivate())->toBeTrue();
    });
});
