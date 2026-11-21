<?php

declare(strict_types=1);
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;

uses(TestCase::class);

it('tests that TestCase class structure is correct', function () {
    /** @var TestCase $this */
    $this->assertInstanceOf(TestCase::class, $this);
    $this->assertTrue(class_exists(TestCase::class));
});

it('XotBasePest helper methods exist', function () {
    /** @var TestCase $this */
    $this->assertTrue(class_exists(XotBasePest::class));
    $reflection = new ReflectionClass(XotBasePest::class);
    $this->assertTrue($reflection->hasMethod('assertFreshModel'));
    $this->assertTrue($reflection->hasMethod('assertFirstModel'));
    $this->assertTrue($reflection->hasMethod('assertTableHas'));
});

it('XotBasePest::assertFreshModel signature validation', function () {
    /** @var TestCase $this */
    $reflection = new ReflectionMethod(XotBasePest::class, 'assertFreshModel');
    $this->assertTrue($reflection->isPublic());
    $parameters = $reflection->getParameters();
    $this->assertCount(2, $parameters);
    $modelParam = $parameters[0];
    $type = $modelParam->getType();
    $this->assertInstanceOf(ReflectionNamedType::class, $type);
    $this->assertSame('Illuminate\Database\Eloquent\Model', $type->getName());
});

it('XotBasePest::assertListContains validates array contents', function () {
    $list = ['value1', 'value2', 'value3'];
    XotBasePest::assertListContains('value2', $list);
});

it('XotBasePest::assertThrows catches expected exceptions', function () {
    XotBasePest::assertThrows(
        fn () => throw new InvalidArgumentException('test'),
        InvalidArgumentException::class
    );
});
