<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit;

use Modules\Cms\Models\Traits\HasBlocks;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
test('HasBlocks getBlocksBySlug handles MultipleRecordsFoundException', function (): void {
    $reflectionClass = new \ReflectionClass(HasBlocks::class);
    $method = $reflectionClass->getMethod('getBlocksBySlug');
    expect($method)->not->toBeNull();
    expect($method->isStatic())->toBeTrue();
    $returnType = $method->getReturnType();
    Assert::assertInstanceOf(\ReflectionNamedType::class, $returnType);
    expect($returnType->getName())->toBe('array');
});

test('getBlocksBySlug method signature is correct', function (): void {
    $reflectionClass = new \ReflectionClass(HasBlocks::class);
    $method = $reflectionClass->getMethod('getBlocksBySlug');
    $params = $method->getParameters();
    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('slug');
    $parameterType = $params[0]->getType();
    Assert::assertInstanceOf(\ReflectionNamedType::class, $parameterType);
    expect($parameterType->getName())->toBe('string');
});
