<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Support;

use PHPUnit\Framework\Assert;
use Throwable;

/**
 * PHPStan-safe assertion chain for Pest tests (avoids Pest\Mixins\Expectation @internal).
 */
final class Ensure
{
    public function __construct(private mixed $value) {}

    public function toBe(mixed $expected): self
    {
        Assert::assertSame($expected, $this->value);

        return $this;
    }

    public function toEqual(mixed $expected): self
    {
        Assert::assertEquals($expected, $this->value);

        return $this;
    }

    public function toEqualCanonicalizing(mixed $expected): self
    {
        Assert::assertEqualsCanonicalizing($expected, $this->value);

        return $this;
    }

    public function toBeTrue(): self
    {
        Assert::assertTrue((bool) $this->value);

        return $this;
    }

    public function toBeFalse(): self
    {
        Assert::assertFalse((bool) $this->value);

        return $this;
    }

    public function toBeNull(): self
    {
        Assert::assertNull($this->value);

        return $this;
    }

    public function toBeEmpty(): self
    {
        Assert::assertEmpty($this->value);

        return $this;
    }

    public function toBeArray(): self
    {
        Assert::assertIsArray($this->value);

        return $this;
    }

    /**
     * @param  list<int|string>  $keys
     */
    public function toHaveKeys(array $keys): self
    {
        Assert::assertIsArray($this->value);
        foreach ($keys as $key) {
            Assert::assertArrayHasKey($key, $this->value);
        }

        return $this;
    }

    public function toHaveKey(int|string $key): self
    {
        Assert::assertIsArray($this->value);
        Assert::assertArrayHasKey($key, $this->value);

        return $this;
    }

    public function and(mixed $value): self
    {
        return new self($value);
    }

    /**
     * @param  callable(): mixed  $callback
     * @param  class-string<Throwable>  $exception
     */
    public static function throws(callable $callback, string $exception, ?string $message = null): void
    {
        $thrown = null;
        try {
            $callback();
        } catch (Throwable $e) {
            $thrown = $e;
        }
        Assert::assertInstanceOf($exception, $thrown);
        if ($message !== null) {
            Assert::assertSame($message, $thrown->getMessage());
        }
    }
}
