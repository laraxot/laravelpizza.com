<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\SMS;

use Modules\Notify\Actions\SMS\SendNetfunSMSAction;
use Modules\Notify\Datas\SmsData;
use Modules\Notify\Models\Contracts\SmsActionContract;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionNamedType;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_encode;

uses(TestCase::class);
test('netfun sms action has the expected public contract', function (): void {
    $reflection = new ReflectionClass(SendNetfunSMSAction::class);
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

function invokeIsSuccessfulResponse(int $statusCode, string $statusTxt): bool
{
    $reflection = new ReflectionClass(SendNetfunSMSAction::class);
    $method = $reflection->getMethod('isSuccessfulResponse');
    $method->setAccessible(true);

    /** @var SendNetfunSMSAction $instance */
    $instance = $reflection->newInstanceWithoutConstructor();

    /** @var bool $result */
    $result = $method->invoke($instance, $statusCode, $statusTxt);

    return $result;
}

test('netfun sms response with http 200 and error 0 is treated as success, not logged as error', function (): void {
    $statusTxt = json_encode([
        'async' => true,
        'error' => 0,
        'credit' => 315848,
        'sending_contacts_count' => 1,
        'sending_batch_id' => '26263325060281687',
    ]);

    Assert::assertTrue(invokeIsSuccessfulResponse(200, $statusTxt));
});

test('netfun sms response with error field set is treated as a real failure', function (): void {
    $statusTxt = json_encode([
        'async' => true,
        'error' => 1,
        'error_message' => 'Credito insufficiente',
    ]);

    Assert::assertFalse(invokeIsSuccessfulResponse(200, $statusTxt));
});

test('netfun sms response with non-2xx http status is treated as a real failure', function (): void {
    Assert::assertFalse(invokeIsSuccessfulResponse(500, '{"error":0}'));
});

test('netfun sms response with malformed body is treated as a real failure', function (): void {
    Assert::assertFalse(invokeIsSuccessfulResponse(200, 'not json'));
});
