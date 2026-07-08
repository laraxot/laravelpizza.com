<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Xot\Contracts\ExtraContract;
use Modules\Xot\Models\Traits\HasExtraTrait;
use Modules\Xot\Tests\Fixtures\Models\ExtraModelTest;
use Modules\Xot\Tests\Fixtures\Models\TestModelHasExtra;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

use Spatie\SchemalessAttributes\SchemalessAttributes;

uses(TestCase::class);

/**
 * @param array<string, mixed> $values
 */
function makeExtraWithValues(array $values): ExtraModelTest
{
    $extra = new ExtraModelTest();
    $attributes = SchemalessAttributes::createForModel($extra, 'extra_attributes');

    foreach ($values as $key => $value) {
        $attributes->set($key, $value);
    }

    $extra->setAttribute('extra_attributes', $attributes);

    return $extra;
}

describe('HasExtraTrait', function (): void {
    $testModel = new TestModelHasExtra();
    $extraClass = new ExtraModelTest();

    it('uses the trait correctly', function () use ($testModel): void {
        $traits = class_uses($testModel);

        Assert::assertContains(HasExtraTrait::class, $traits);
    });

    it('has extra relationship method', function () use ($testModel): void {
        $relation = $testModel->extra();

        Assert::assertInstanceOf(MorphOne::class, $relation);
    });

    it('returns null for non-existent extra', function () use ($testModel): void {
        $result = $testModel->getExtra('non_existent_key');

        Assert::assertNull($result);
    });

    it('can set and get extra attributes', function () use ($testModel): void {
        $testModel->extra = makeExtraWithValues(['test_key' => 'test_value']);

        $result = $testModel->getExtra('test_key');

        Assert::assertSame('test_value', $result);
    });

    it('handles different data types correctly', function () use ($testModel): void {
        $testModel->extra = makeExtraWithValues([
            'string_value' => 'test_string',
            'int_value' => 123,
            'bool_value' => true,
            'array_value' => ['nested', 'array'],
            'null_value' => null,
        ]);

        Assert::assertSame('test_string', $testModel->getExtra('string_value'));
        Assert::assertSame(123, $testModel->getExtra('int_value'));
        Assert::assertSame(true, $testModel->getExtra('bool_value'));
        Assert::assertSame(['nested', 'array'], $testModel->getExtra('array_value'));
        Assert::assertNull($testModel->getExtra('null_value'));
    });

    it('returns null for unsupported stored types', function () use ($testModel): void {
        $testModel->extra = makeExtraWithValues([
            'invalid_value' => new \stdClass(),
        ]);

        Assert::assertNull($testModel->getExtra('invalid_value'));
    });

    it('validates method signatures', function () use ($testModel): void {
        $reflection = new \ReflectionClass($testModel);

        $getExtraMethod = $reflection->getMethod('getExtra');
        Assert::assertTrue($getExtraMethod->isPublic());
        $parameters = $getExtraMethod->getParameters();
        Assert::assertCount(1, $parameters);
        Assert::assertSame('name', $parameters[0]->getName());
        $paramType = $parameters[0]->getType();
        if ($paramType instanceof \ReflectionNamedType) {
            Assert::assertSame('string', $paramType->getName());
        }

        $setExtraMethod = $reflection->getMethod('setExtra');
        Assert::assertTrue($setExtraMethod->isPublic());
        $setParameters = $setExtraMethod->getParameters();
        Assert::assertCount(2, $setParameters);
        Assert::assertSame('name', $setParameters[0]->getName());
        $setParamType = $setParameters[0]->getType();
        if ($setParamType instanceof \ReflectionNamedType) {
            Assert::assertSame('string', $setParamType->getName());
        }
    });

    it('has proper return type annotations', function () use ($testModel): void {
        $reflection = new \ReflectionClass($testModel);
        $method = $reflection->getMethod('getExtra');

        Assert::assertNotNull($method->getReturnType());
    });

    it('handles extra relationship correctly', function () use ($testModel): void {
        $extraMethod = new \ReflectionMethod($testModel, 'extra');

        Assert::assertTrue($extraMethod->isPublic());
    });

    it('handles empty extra attributes', function () use ($testModel): void {
        $testModel->extra = makeExtraWithValues([]);

        $result = $testModel->getExtra('non_existent');
        Assert::assertNull($result);
    });

    it('validates extra class contract', function () use ($extraClass): void {
        $reflection = new \ReflectionClass($extraClass);

        Assert::assertTrue($reflection->implementsInterface(ExtraContract::class));
    });

    it('has proper documentation', function (): void {
        $reflection = new \ReflectionClass(HasExtraTrait::class);
        $getExtraMethod = $reflection->getMethod('getExtra');

        $docComment = $getExtraMethod->getDocComment();
        Assert::assertIsString($docComment);
        Assert::assertStringContainsString('@return', $docComment);
    });
});
