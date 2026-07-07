<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Support;

use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

/**
 * @property self $not Negated expectation (resolved via __get).
 */
final class PestExpectation
{
    public function __construct(
        private readonly mixed $value,
        private readonly bool $negated = false,
    ) {
    }

    public function __get(string $name): self
    {
        if ('not' === $name) {
            return $this->not();
        }

        Assert::fail('Unknown expectation property: '.$name);
    }

    public function not(): self
    {
        return new self($this->value, ! $this->negated);
    }

    public function and(mixed $value): self
    {
        return new self($value);
    }

    public function toBe(mixed $expected): self
    {
        $this->negated
            ? Assert::assertNotSame($expected, $this->value)
            : Assert::assertSame($expected, $this->value);

        return $this;
    }

    public function toEqual(mixed $expected): self
    {
        $this->negated
            ? Assert::assertNotEquals($expected, $this->value)
            : Assert::assertEquals($expected, $this->value);

        return $this;
    }

    public function toBeTrue(): self
    {
        $this->negated ? Assert::assertNotTrue($this->value) : Assert::assertTrue($this->value);

        return $this;
    }

    public function toBeFalse(): self
    {
        $this->negated ? Assert::assertNotFalse($this->value) : Assert::assertFalse($this->value);

        return $this;
    }

    public function toBeNull(): self
    {
        $this->negated ? Assert::assertNotNull($this->value) : Assert::assertNull($this->value);

        return $this;
    }

    public function toBeArray(): self
    {
        $this->negated ? Assert::assertFalse(is_array($this->value)) : Assert::assertIsArray($this->value);

        return $this;
    }

    public function toBeString(): self
    {
        $this->negated ? Assert::assertFalse(is_string($this->value)) : Assert::assertIsString($this->value);

        return $this;
    }

    public function toBeInt(): self
    {
        $this->negated ? Assert::assertFalse(is_int($this->value)) : Assert::assertIsInt($this->value);

        return $this;
    }

    public function toBeFloat(): self
    {
        $this->negated ? Assert::assertFalse(is_float($this->value)) : Assert::assertIsFloat($this->value);

        return $this;
    }

    public function toBeBool(): self
    {
        $this->negated ? Assert::assertFalse(is_bool($this->value)) : Assert::assertIsBool($this->value);

        return $this;
    }

    public function toBeObject(): self
    {
        $this->negated ? Assert::assertFalse(is_object($this->value)) : Assert::assertIsObject($this->value);

        return $this;
    }

    public function toBeEmpty(): self
    {
        $this->negated ? Assert::assertNotEmpty($this->value) : Assert::assertEmpty($this->value);

        return $this;
    }

    /**
     * @param class-string $expectedClass
     */
    public function toBeInstanceOf(string $expectedClass): self
    {
        $this->negated
            ? Assert::assertNotInstanceOf($expectedClass, $this->value)
            : Assert::assertInstanceOf($expectedClass, $this->value);

        return $this;
    }

    public function toHaveCount(int $count): self
    {
        if ($this->negated) {
            Assert::assertNotCount($count, $this->normaliseCountable($this->value));

            return $this;
        }

        Assert::assertCount($count, $this->normaliseCountable($this->value));

        return $this;
    }

    public function toContain(mixed ...$needles): self
    {
        foreach ($needles as $needle) {
            if (is_string($this->value)) {
                $this->negated
                    ? Assert::assertStringNotContainsString(SafeStringCastAction::cast($needle), $this->value)
                    : Assert::assertStringContainsString(SafeStringCastAction::cast($needle), $this->value);

                continue;
            }

            $haystack = $this->normaliseIterable($this->value);
            $this->negated
                ? Assert::assertNotContains($needle, $haystack)
                : Assert::assertContains($needle, $haystack);
        }

        return $this;
    }

    public function toHaveKey(mixed $key): self
    {
        if (! is_int($key) && ! is_string($key)) {
            Assert::fail('Expected key must be an integer or string.');
        }

        if ($this->value instanceof \ArrayAccess) {
            $exists = $this->value->offsetExists($key);
            $this->negated ? Assert::assertFalse($exists) : Assert::assertTrue($exists);

            return $this;
        }

        Assert::assertIsArray($this->value);
        $this->negated
            ? Assert::assertArrayNotHasKey($key, $this->value)
            : Assert::assertArrayHasKey($key, $this->value);

        return $this;
    }

    /**
     * @param iterable<array-key> $keys
     */
    public function toHaveKeys(iterable $keys): self
    {
        foreach ($keys as $key) {
            $this->toHaveKey($key);
        }

        return $this;
    }

    public function toHaveProperty(string $property, mixed $expectedValue = null): self
    {
        Assert::assertIsObject($this->value);
        $exists = property_exists($this->value, $property) || isset($this->value->{$property});
        $this->negated ? Assert::assertFalse($exists) : Assert::assertTrue($exists);

        if (2 === func_num_args() && ! $this->negated) {
            Assert::assertEquals($expectedValue, $this->value->{$property});
        }

        return $this;
    }

    /**
     * @param iterable<string> $properties
     */
    public function toHaveProperties(iterable $properties): self
    {
        foreach ($properties as $property) {
            $this->toHaveProperty($property);
        }

        return $this;
    }

    public function toMatch(string $pattern): self
    {
        $this->negated
            ? Assert::assertDoesNotMatchRegularExpression($pattern, SafeStringCastAction::cast($this->value))
            : Assert::assertMatchesRegularExpression($pattern, SafeStringCastAction::cast($this->value));

        return $this;
    }

    /**
     * @param array<array-key, mixed> $expectedSubset
     */
    public function toMatchArray(array $expectedSubset): self
    {
        Assert::assertIsArray($this->value);

        foreach ($expectedSubset as $key => $expectedValue) {
            Assert::assertArrayHasKey($key, $this->value);
            $this->negated
                ? Assert::assertNotEquals($expectedValue, $this->value[$key])
                : Assert::assertEquals($expectedValue, $this->value[$key]);
        }

        return $this;
    }

    public function toBeGreaterThan(mixed $expected): self
    {
        $this->negated
            ? Assert::assertLessThanOrEqual($expected, $this->value)
            : Assert::assertGreaterThan($expected, $this->value);

        return $this;
    }

    public function toBeGreaterThanOrEqual(mixed $expected): self
    {
        $this->negated
            ? Assert::assertLessThan($expected, $this->value)
            : Assert::assertGreaterThanOrEqual($expected, $this->value);

        return $this;
    }

    public function toBeLessThan(mixed $expected): self
    {
        $this->negated
            ? Assert::assertGreaterThanOrEqual($expected, $this->value)
            : Assert::assertLessThan($expected, $this->value);

        return $this;
    }

    public function toBeLessThanOrEqual(mixed $expected): self
    {
        $this->negated
            ? Assert::assertGreaterThan($expected, $this->value)
            : Assert::assertLessThanOrEqual($expected, $this->value);

        return $this;
    }

    /**
     * @param iterable<mixed> $expectedValues
     */
    public function toBeIn(iterable $expectedValues): self
    {
        $values = $this->normaliseIterable($expectedValues);
        $this->negated
            ? Assert::assertNotContains($this->value, $values)
            : Assert::assertContains($this->value, $values);

        return $this;
    }

    public function toStartWith(string $prefix): self
    {
        if ('' === $prefix) {
            Assert::fail('Expected a non-empty prefix.');
        }

        $this->negated
            ? Assert::assertStringStartsNotWith($prefix, SafeStringCastAction::cast($this->value))
            : Assert::assertStringStartsWith($prefix, SafeStringCastAction::cast($this->value));

        return $this;
    }

    public function toEndWith(string $suffix): self
    {
        if ('' === $suffix) {
            Assert::fail('Expected a non-empty suffix.');
        }

        $this->negated
            ? Assert::assertStringEndsNotWith($suffix, SafeStringCastAction::cast($this->value))
            : Assert::assertStringEndsWith($suffix, SafeStringCastAction::cast($this->value));

        return $this;
    }

    public function toBeFile(): self
    {
        Assert::assertIsString($this->value);
        $this->negated ? Assert::assertFileDoesNotExist($this->value) : Assert::assertFileExists($this->value);

        if (! $this->negated) {
            Assert::assertTrue(is_file($this->value));
        }

        return $this;
    }

    public function toBeDirectory(): self
    {
        Assert::assertIsString($this->value);
        $this->negated ? Assert::assertDirectoryDoesNotExist($this->value) : Assert::assertDirectoryExists($this->value);

        return $this;
    }

    public function toThrow(mixed ...$constraints): self
    {
        Assert::assertIsCallable($this->value);

        if ($this->negated) {
            PestAssert::doesNotThrow($this->value);

            return $this;
        }

        PestAssert::throws($this->value, ...$constraints);

        return $this;
    }

    public function throws(mixed ...$constraints): self
    {
        return $this->toThrow(...$constraints);
    }

    /**
     * @return array<array-key, mixed>|\Countable
     */
    private function normaliseCountable(mixed $value): array|\Countable
    {
        if ($value instanceof \Countable) {
            return $value;
        }

        return $this->normaliseIterable($value);
    }

    /**
     * @return array<array-key, mixed>
     */
    private function normaliseIterable(mixed $value): array
    {
        if ($value instanceof \Traversable) {
            return iterator_to_array($value);
        }

        Assert::assertIsArray($value);

        return $value;
    }
}
