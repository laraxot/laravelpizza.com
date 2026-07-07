<?php

declare(strict_types=1);

use Modules\Notify\Actions\SMS\SendAgiletelecomSMSv2Action;
use Modules\Notify\Datas\SmsData;

describe('SendAgiletelecomSMSv2Action', function () {
    it('can be instantiated', function () {
        /** @phpstan-ignore method.internalClass */
        expect(new SendAgiletelecomSMSv2Action)->toBeInstanceOf(SendAgiletelecomSMSv2Action::class);
    });

    it('implements SmsActionContract', function () {
        /** @phpstan-ignore method.internalClass */
        expect(new SendAgiletelecomSMSv2Action)->toBeObject();
    });

    it('has execute method with correct signature', function () {
        $reflection = new \ReflectionClass(new SendAgiletelecomSMSv2Action);
        $method = $reflection->getMethod('execute');

        /** @phpstan-ignore method.internalClass */
        expect($method->isPublic())->toBeTrue();
        /** @phpstan-ignore method.internalClass */
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new \ReflectionClass(new SendAgiletelecomSMSv2Action);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();
        $type = $params[0]->getType();

        /** @phpstan-ignore method.internalClass */
        expect($type)->toBeInstanceOf(\ReflectionNamedType::class);
        /** @phpstan-ignore method.internalClass */
        expect($type instanceof \ReflectionNamedType ? $type->getName() : '')->toBe(SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new \ReflectionClass(new SendAgiletelecomSMSv2Action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        /** @phpstan-ignore method.internalClass */
        expect($returnType)->toBeInstanceOf(\ReflectionNamedType::class);
        /** @phpstan-ignore method.internalClass */
        expect($returnType instanceof \ReflectionNamedType ? $returnType->getName() : '')->toBe('array');
    });

    it('uses strict types', function () {
        $reflection = new \ReflectionClass(new SendAgiletelecomSMSv2Action);
        $filename = $reflection->getFileName();

        /** @phpstan-ignore method.internalClass */
        expect($filename)->not->toBeNull();
        /** @var string $filename */
        $content = \Safe\file_get_contents($filename);
        /** @phpstan-ignore method.internalClass */
        expect($content)->toContain('declare(strict_types=1)');
    });

    it('has correct namespace', function () {
        $reflection = new \ReflectionClass(new SendAgiletelecomSMSv2Action);

        /** @phpstan-ignore method.internalClass */
        expect($reflection->getNamespaceName())->toBe('Modules\\Notify\\Actions\\SMS');
    });

    it('has required imports', function () {
        $reflection = new \ReflectionClass(new SendAgiletelecomSMSv2Action);
        $filename = $reflection->getFileName();
        /** @var string $filename */
        $content = \Safe\file_get_contents($filename);

        /** @phpstan-ignore method.internalClass */
        expect($content)->toContain('use Illuminate\\Support\\Facades\\Http;');
        /** @phpstan-ignore method.internalClass */
        expect($content)->toContain('use Modules\\Notify\\Datas\\SMS\\AgiletelecomData;');
    });

    it('does not use QueueableAction trait', function () {
        $traits = \Safe\class_uses(new SendAgiletelecomSMSv2Action);

        /** @phpstan-ignore method.internalClass */
        expect($traits)->not->toContain('Spatie\\QueueableAction\\QueueableAction');
    });
});
