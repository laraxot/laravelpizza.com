<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\SendTwilioSMSAction;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionNamedType;
use Spatie\QueueableAction\QueueableAction;

uses(TestCase::class);
test('twilio sms action has the expected public contract', function (): void {
    $reflection = new ReflectionClass(SendTwilioSMSAction::class);
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
