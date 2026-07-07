<?php

declare(strict_types=1);

use Modules\Notify\Actions\SMS\SendAgiletelecomSMSAction;
use Modules\Notify\Datas\SmsData;


it('SendAgiletelecomSMSAction can be instantiated', function () {
    $action = new SendAgiletelecomSMSAction;
    /** @phpstan-ignore method.internalClass */
    expect($action)->toBeInstanceOf(SendAgiletelecomSMSAction::class);
});

it('SendAgiletelecomSMSAction has execute method with correct signature', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('execute');

    /** @phpstan-ignore method.internalClass */
    expect($method->isPublic())->toBeTrue();
    /** @phpstan-ignore method.internalClass */
    expect($method->getNumberOfParameters())->toBe(1);
});

it('SendAgiletelecomSMSAction execute accepts SmsData parameter', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('execute');
    $params = $method->getParameters();
    $type = $params[0]->getType();

    /** @phpstan-ignore method.internalClass */
    expect($type instanceof \ReflectionNamedType ? $type->getName() : null)->toBe(SmsData::class);
});

it('SendAgiletelecomSMSAction execute returns array', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new \ReflectionClass($action);
    $method = $reflection->getMethod('execute');
    $returnType = $method->getReturnType();

    /** @phpstan-ignore method.internalClass */
    expect($returnType instanceof \ReflectionNamedType ? $returnType->getName() : null)->toBe('array');
});

it('SendAgiletelecomSMSAction uses strict types', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new \ReflectionClass($action);
    $filename = $reflection->getFileName();

    /** @phpstan-ignore method.internalClass */
    expect($filename)->not->toBeNull();
    /** @var string $filename */
    $content = \Safe\file_get_contents($filename);
    /** @phpstan-ignore method.internalClass */
    expect($content)->toContain('declare(strict_types=1)');
});

it('SendAgiletelecomSMSAction has correct namespace', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new \ReflectionClass($action);

    /** @phpstan-ignore method.internalClass */
    expect($reflection->getNamespaceName())->toBe('Modules\\Notify\\Actions\\SMS');
});

it('SendAgiletelecomSMSAction has required imports', function () {
    $action = new SendAgiletelecomSMSAction;
    $reflection = new \ReflectionClass($action);
    $filename = $reflection->getFileName();
    /** @var string $filename */
    $content = \Safe\file_get_contents($filename);

    /** @phpstan-ignore method.internalClass */
    expect($content)->toContain('use Modules\\Notify\\Contracts\\SMS\\SmsActionContract;');
    /** @phpstan-ignore method.internalClass */
    expect($content)->toContain('use Modules\\Notify\\Datas\\SmsData;');
});

it('SendAgiletelecomSMSAction does not use QueueableAction trait', function () {
    $action = new SendAgiletelecomSMSAction;
    $traits = \Safe\class_uses($action);

    /** @phpstan-ignore method.internalClass */
    expect($traits)->not->toContain('Spatie\\QueueableAction\\QueueableAction');
});
