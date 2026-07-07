<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions;

use Modules\Notify\Actions\NetfunSendAction;
use Modules\Notify\Datas\SmsData;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionNamedType;
use Spatie\QueueableAction\QueueableAction;

test('netfun send action has the expected public contract', function (): void {
    $reflection = new ReflectionClass(NetfunSendAction::class);
    $method = $reflection->getMethod('execute');
    $parameters = $method->getParameters();
    $parameterType = $parameters[0]->getType();
    $returnType = $method->getReturnType();

    Assert::assertTrue($reflection->isInstantiable());
    Assert::assertContains(QueueableAction::class, $reflection->getTraitNames());
    Assert::assertTrue($method->isPublic());
    Assert::assertCount(1, $parameters);
    Assert::assertInstanceOf(ReflectionNamedType::class, $parameterType);
    Assert::assertSame(SmsData::class, $parameterType->getName());
    Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
    Assert::assertSame('array', $returnType->getName());
});

test('netfun send action exposes state used by execute', function (): void {
    $reflection = new ReflectionClass(NetfunSendAction::class);

    Assert::assertSame('Modules\\Notify\\Actions', $reflection->getNamespaceName());
    Assert::assertTrue($reflection->hasProperty('token'));
    Assert::assertTrue($reflection->hasProperty('vars'));
});
