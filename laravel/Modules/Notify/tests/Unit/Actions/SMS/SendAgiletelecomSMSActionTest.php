<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\SendAgiletelecomSMSAction;
use Modules\Notify\Datas\SmsData;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionNamedType;

uses(\Modules\Notify\Tests\TestCase::class);
it('SendAgiletelecomSMSAction can be instantiated', function () {
    Assert::assertTrue(class_exists(SendAgiletelecomSMSAction::class));
});

it('SendAgiletelecomSMSAction has execute method with correct signature', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new ReflectionClass($action);
    $method = $reflection->getMethod('execute');

    expect($method->isPublic())->toBeTrue();
    expect($method->getNumberOfParameters())->toBe(1);
});

it('SendAgiletelecomSMSAction execute accepts SmsData parameter', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new ReflectionClass($action);
    $method = $reflection->getMethod('execute');
    $params = $method->getParameters();
    $type = $params[0]->getType();

    expect($type instanceof ReflectionNamedType ? $type->getName() : null)->toBe(SmsData::class);
});

it('SendAgiletelecomSMSAction execute returns array', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new ReflectionClass($action);
    $method = $reflection->getMethod('execute');
    $returnType = $method->getReturnType();

    expect($returnType instanceof ReflectionNamedType ? $returnType->getName() : null)->toBe('array');
});

it('SendAgiletelecomSMSAction uses strict types', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new ReflectionClass($action);
    $filename = $reflection->getFileName();

    expect($filename)->not->toBeNull();
    /** @var string $filename */
    $content = \Safe\file_get_contents($filename);
    expect($content)->toContain('declare(strict_types=1)');
});

it('SendAgiletelecomSMSAction has correct namespace', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new ReflectionClass($action);

    expect($reflection->getNamespaceName())->toBe('Modules\\Notify\\Actions\\SMS');
});

it('SendAgiletelecomSMSAction has required imports', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new ReflectionClass($action);
    $filename = $reflection->getFileName();
    /** @var string $filename */
    $content = \Safe\file_get_contents($filename);

    expect($content)->toContain('use Modules\\Notify\\Models\\Contracts\\SmsActionContract;');
    expect($content)->toContain('use Modules\\Notify\\Datas\\SmsData;');
});

it('SendAgiletelecomSMSAction uses QueueableAction trait', function () {
    $action = new SendAgiletelecomSMSAction;
    $traits = \Safe\class_uses($action);

    expect($traits)->toContain('Spatie\\QueueableAction\\QueueableAction');
});