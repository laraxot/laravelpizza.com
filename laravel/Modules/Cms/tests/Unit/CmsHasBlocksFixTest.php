<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit;

use PHPUnit\Framework\Assert;

test('HasBlocks getBlocksBySlug handles MultipleRecordsFoundException', function (): void {
    $reflectionClass = new \ReflectionClass(\Modules\Cms\Models\Traits\HasBlocks::class);
    $method = $reflectionClass->getMethod('getBlocksBySlug');
    expect($method)->not->toBeNull();
    expect($method->isStatic())->toBeTrue();
    $returnType = $method->getReturnType();
    Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType);
    expect($returnType->getName())->toBe('array');
});

test('getBlocksBySlug method signature is correct', function (): void {
    $reflectionClass = new \ReflectionClass(\Modules\Cms\Models\Traits\HasBlocks::class);
    $method = $reflectionClass->getMethod('getBlocksBySlug');
    $params = $method->getParameters();
    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('slug');
    $parameterType = $params[0]->getType();
    Assert::assertInstanceOf(\ReflectionNamedType::class, $parameterType);
    expect($parameterType->getName())->toBe('string');
});
