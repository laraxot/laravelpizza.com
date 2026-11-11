<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\SendAgiletelecomSMSv1Action;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionNamedType;

uses(TestCase::class);
describe('SendAgiletelecomSMSv1Action', function () {
    it('can be instantiated', function () {
        Assert::assertTrue(class_exists(SendAgiletelecomSMSv1Action::class));
    });

    it('implements SmsActionContract', function () {
        Assert::assertSame(
            'Modules\\Notify\\Actions\\SMS',
            (new ReflectionClass(SendAgiletelecomSMSv1Action::class))->getNamespaceName(),
        );
    });

    it('has execute method with correct signature', function () {
        $reflection = new ReflectionClass(new SendAgiletelecomSMSv1Action);
        $method = $reflection->getMethod('execute');

        expect($method->isPublic())->toBeTrue();
        expect($method->getNumberOfParameters())->toBe(1);
    });

    it('execute accepts SmsData parameter', function () {
        $reflection = new ReflectionClass(new SendAgiletelecomSMSv1Action);
        $method = $reflection->getMethod('execute');
        $params = $method->getParameters();
        $type = $params[0]->getType();

        expect($type)->toBeInstanceOf(ReflectionNamedType::class);
        expect($type instanceof ReflectionNamedType ? $type->getName() : '')->toBe(SmsData::class);
    });

    it('execute returns array', function () {
        $reflection = new ReflectionClass(new SendAgiletelecomSMSv1Action);
        $method = $reflection->getMethod('execute');
        $returnType = $method->getReturnType();

        expect($returnType)->toBeInstanceOf(ReflectionNamedType::class);
        expect($returnType instanceof ReflectionNamedType ? $returnType->getName() : '')->toBe('array');
    });

    it('uses strict types', function () {
        $reflection = new ReflectionClass(new SendAgiletelecomSMSv1Action);
        $filename = $reflection->getFileName();

        expect($filename)->not->toBeNull();
        /** @var string $filename */
        $content = \Safe\file_get_contents($filename);
        expect($content)->toContain('declare(strict_types=1)');
    });

    it('has correct namespace', function () {
        $reflection = new ReflectionClass(new SendAgiletelecomSMSv1Action);

        expect($reflection->getNamespaceName())->toBe('Modules\\Notify\\Actions\\SMS');
    });

    it('has required imports', function () {
        $reflection = new ReflectionClass(new SendAgiletelecomSMSv1Action);
        $filename = $reflection->getFileName();
        /** @var string $filename */
        $content = \Safe\file_get_contents($filename);

        expect($content)->toContain('use GuzzleHttp\\Client;');
        expect($content)->toContain('use Modules\\Notify\\Datas\\SMS\\AgiletelecomData;');
    });

    it('uses QueueableAction trait', function () {
        $traits = \Safe\class_uses(new SendAgiletelecomSMSv1Action);

        expect($traits)->toContain('Spatie\\QueueableAction\\QueueableAction');
    });
});
