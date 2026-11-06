<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\SendNexmoSMSAction;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionNamedType;
use Spatie\QueueableAction\QueueableAction;

uses(\Modules\Notify\Tests\TestCase::class);
test('nexmo sms action has the expected public contract', function (): void {
    $reflection = new ReflectionClass(SendNexmoSMSAction::class);
    $method = $reflection->getMethod('execute');
    $parameters = $method->getParameters();
    $parameterType = $parameters[0]->getType();
    $returnType = $method->getReturnType();

    Assert::assertTrue($reflection->implementsInterface(SmsActionContract::class));
    Assert::assertContains(QueueableAction::class, $reflection->getTraitNames());
    Assert::assertTrue($method->isPublic());
    Assert::assertCount(1, $parameters);
    Assert::assertInstanceOf(ReflectionNamedType::class, $parameterType);
    Assert::assertSame(SmsData::class, $parameterType->getName());
    Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
    Assert::assertSame('array', $returnType->getName());
});