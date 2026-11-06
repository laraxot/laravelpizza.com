<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Factory\GetFactoryAction;

/**
 * Provides factory support for models using GetFactoryAction.
 *
 * Usage: just use the trait in your model. No type parameters needed.
 *
 * DO NOT DELETE the `$count`/`$state` parameters from factory() below.
 * This trait has been silently broken 5+ times by well-meaning simplifications
 * (removing "unused" params). Every time, it silently regresses a real call site
 * instead of throwing: PHP does not error when you call a user-defined method with
 * more positional args than it declares, it just discards them. `User::factory(5)`
 * needs $count to reach ->count(5) or it silently creates 1 record instead of 5.
 *
 * PHPStan: return is `Factory<static>` so `Model::factory()->create()` is typed.
 * Prefer this over per-test `ModelFactory::new()` when the trait contract holds.
 *
 * @see docs/wiki/second-brain/phpstan-journey.md (Model::factory → mixed)
 * @see docs/wiki/patterns/phpstan-eloquent-typing-without-baseline.md
 *
 * @mixin Model
 */
trait HasXotFactory
{
    /**
     * Get a new factory instance for the model (Laravel HasFactory-compatible).
     *
     * @param  (callable(array<string, mixed>, Model|null): array<string, mixed>)|array<string, mixed>|int|null  $count
     * @param  (callable(array<string, mixed>, Model|null): array<string, mixed>)|array<string, mixed>  $state
     * @return Factory<static>
     */
    public static function factory(callable|array|int|null $count = null, callable|array $state = []): Factory
    {
        $factory = (new GetFactoryAction)->execute(static::class);
        $factoryState = is_callable($count)
            ? $count
            : (is_array($count) ? self::normalizeState($count) : $state);

        return $factory
            ->count(is_numeric($count) ? (int) $count : null)
            ->state($factoryState);
    }

    /**
     * @param  array<array-key, mixed>  $state
     * @return array<string, mixed>
     */
    private static function normalizeState(array $state): array
    {
        $normalized = [];

        foreach ($state as $key => $value) {
            if (! is_string($key)) {
                throw new \InvalidArgumentException('Factory state keys must be strings.');
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }
}
