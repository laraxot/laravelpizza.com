<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Support;

use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

/**
 * PHPStan-safe assertion facade for Pest test closures.
 *
 * Tests remain Pest files (`test()`/`it()`); this class only avoids direct calls
 * to Pest internal expectation mixins when PHPStan analyzes module tests.
 */
final class PestAssert
{
    public static function same(mixed $expected, mixed $actual): void
    {
        Assert::assertSame($expected, $actual);
    }

    public static function notSame(mixed $expected, mixed $actual): void
    {
        Assert::assertNotSame($expected, $actual);
    }

    public static function equal(mixed $expected, mixed $actual): void
    {
        Assert::assertEquals($expected, $actual);
    }

    public static function true(mixed $actual): void
    {
        Assert::assertTrue($actual);
    }

    public static function false(mixed $actual): void
    {
        Assert::assertFalse($actual);
    }

    public static function null(mixed $actual): void
    {
        Assert::assertNull($actual);
    }

    public static function notNull(mixed $actual): void
    {
        Assert::assertNotNull($actual);
    }

    public static function isArray(mixed $actual): void
    {
        Assert::assertIsArray($actual);
    }

    public static function isString(mixed $actual): void
    {
        Assert::assertIsString($actual);
    }

    public static function isInt(mixed $actual): void
    {
        Assert::assertIsInt($actual);
    }

    public static function isFloat(mixed $actual): void
    {
        Assert::assertIsFloat($actual);
    }

    public static function isBool(mixed $actual): void
    {
        Assert::assertIsBool($actual);
    }

    public static function isObject(mixed $actual): void
    {
        Assert::assertIsObject($actual);
    }

    /**
     * @param class-string $expectedClass
     */
    public static function instanceOf(string $expectedClass, mixed $actual): void
    {
        Assert::assertInstanceOf($expectedClass, $actual);
    }

    public static function count(mixed $expectedCount, mixed $actual): void
    {
        if (! is_int($expectedCount)) {
            Assert::fail('Expected count must be an integer.');
        }

        if ($actual instanceof \Countable) {
            Assert::assertCount($expectedCount, $actual);

            return;
        }

        if ($actual instanceof \Traversable) {
            $actual = iterator_to_array($actual);
        }

        Assert::assertIsArray($actual);
        Assert::assertCount($expectedCount, $actual);
    }

    public static function empty(mixed $actual): void
    {
        Assert::assertEmpty($actual);
    }

    public static function notEmpty(mixed $actual): void
    {
        Assert::assertNotEmpty($actual);
    }

    public static function contains(mixed $needle, mixed $actual): void
    {
        if (is_string($actual)) {
            Assert::assertStringContainsString(SafeStringCastAction::cast($needle), $actual);

            return;
        }

        if ($actual instanceof \Traversable) {
            $actual = iterator_to_array($actual);
        }

        Assert::assertIsArray($actual);
        Assert::assertContains($needle, $actual);
    }

    public static function notContains(mixed $needle, mixed $actual): void
    {
        if (is_string($actual)) {
            Assert::assertStringNotContainsString(SafeStringCastAction::cast($needle), $actual);

            return;
        }

        if ($actual instanceof \Traversable) {
            $actual = iterator_to_array($actual);
        }

        Assert::assertIsArray($actual);
        Assert::assertNotContains($needle, $actual);
    }

    public static function hasKey(mixed $key, mixed $actual): void
    {
        if (! is_int($key) && ! is_string($key)) {
            Assert::fail('Expected key must be an integer or string.');
        }

        if (is_array($actual)) {
            Assert::assertArrayHasKey($key, $actual);

            return;
        }

        if ($actual instanceof \ArrayAccess) {
            Assert::assertTrue($actual->offsetExists($key));

            return;
        }

        Assert::fail('Expected array or ArrayAccess for key assertion.');
    }

    public static function notHasKey(mixed $key, mixed $actual): void
    {
        if (! is_int($key) && ! is_string($key)) {
            Assert::fail('Expected key must be an integer or string.');
        }

        if (is_array($actual)) {
            Assert::assertArrayNotHasKey($key, $actual);

            return;
        }

        if ($actual instanceof \ArrayAccess) {
            Assert::assertFalse($actual->offsetExists($key));

            return;
        }

        Assert::fail('Expected array or ArrayAccess for key assertion.');
    }

    /**
     * @param iterable<array-key> $keys
     */
    public static function hasKeys(iterable $keys, mixed $actual): void
    {
        foreach ($keys as $key) {
            self::hasKey($key, $actual);
        }
    }

    public static function hasProperty(mixed $property, mixed $actual): void
    {
        Assert::assertIsString($property);
        Assert::assertIsObject($actual);
        Assert::assertTrue(property_exists($actual, $property) || isset($actual->{$property}));
    }

    /**
     * @param iterable<string> $properties
     */
    public static function hasProperties(iterable $properties, mixed $actual): void
    {
        foreach ($properties as $property) {
            self::hasProperty($property, $actual);
        }
    }

    public static function matches(mixed $pattern, mixed $actual): void
    {
        Assert::assertIsString($pattern);
        Assert::assertMatchesRegularExpression($pattern, SafeStringCastAction::cast($actual));
    }

    public static function matchesArray(mixed $expectedSubset, mixed $actual): void
    {
        Assert::assertIsArray($expectedSubset);
        Assert::assertIsArray($actual);

        foreach ($expectedSubset as $key => $expectedValue) {
            self::hasKey($key, $actual);
            Assert::assertEquals($expectedValue, $actual[$key]);
        }
    }

    public static function greaterThan(mixed $expected, mixed $actual): void
    {
        Assert::assertGreaterThan($expected, $actual);
    }

    public static function greaterThanOrEqual(mixed $expected, mixed $actual): void
    {
        Assert::assertGreaterThanOrEqual($expected, $actual);
    }

    public static function lessThan(mixed $expected, mixed $actual): void
    {
        Assert::assertLessThan($expected, $actual);
    }

    public static function lessThanOrEqual(mixed $expected, mixed $actual): void
    {
        Assert::assertLessThanOrEqual($expected, $actual);
    }

    public static function in(mixed $actual, mixed $expectedValues): void
    {
        if ($expectedValues instanceof \Traversable) {
            $expectedValues = iterator_to_array($expectedValues);
        }

        Assert::assertIsArray($expectedValues);
        Assert::assertContains($actual, $expectedValues);
    }

    public static function startsWith(mixed $prefix, mixed $actual): void
    {
        Assert::assertIsString($prefix);

        if ('' === $prefix) {
            Assert::fail('Expected a non-empty prefix.');
        }

        Assert::assertStringStartsWith($prefix, SafeStringCastAction::cast($actual));
    }

    public static function endsWith(mixed $suffix, mixed $actual): void
    {
        Assert::assertIsString($suffix);

        if ('' === $suffix) {
            Assert::fail('Expected a non-empty suffix.');
        }

        Assert::assertStringEndsWith($suffix, SafeStringCastAction::cast($actual));
    }

    public static function file(mixed $path): void
    {
        Assert::assertIsString($path);
        Assert::assertFileExists($path);
        Assert::assertTrue(is_file($path));
    }

    public static function directory(mixed $path): void
    {
        Assert::assertIsString($path);
        Assert::assertDirectoryExists($path);
    }

    public static function throws(callable $callback, mixed ...$constraints): void
    {
        try {
            $callback();
        } catch (\Throwable $exception) {
            self::assertThrownExceptionMatches($exception, $constraints);

            return;
        }

        Assert::fail('Expected exception was not thrown.');
    }

    public static function doesNotThrow(callable $callback): void
    {
        try {
            $callback();
        } catch (\Throwable $exception) {
            Assert::fail('Unexpected exception was thrown: '.$exception::class.' '.$exception->getMessage());
        }
    }

    /**
     * @param array<array-key, mixed> $constraints
     */
    private static function assertThrownExceptionMatches(\Throwable $exception, array $constraints): void
    {
        foreach ($constraints as $constraint) {
            if (is_string($constraint) && class_exists($constraint) && is_a($constraint, \Throwable::class, true)) {
                Assert::assertInstanceOf($constraint, $exception);

                continue;
            }

            if (is_string($constraint) && '' !== $constraint) {
                Assert::assertStringContainsString($constraint, $exception->getMessage());
            }
        }
    }
}
