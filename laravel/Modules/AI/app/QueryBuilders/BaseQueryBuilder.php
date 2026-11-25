<?php

declare(strict_types=1);

namespace Modules\Xot\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Base query builder providing chainable query abstractions for models.
 *
 * Extend this class to create query builder implementations for specific models.
 * Query builders encapsulate complex query logic and provide a fluent interface.
 *
 * Example usage:
 *     $tickets = (new TicketQueryBuilder())
 *         ->whereStatus('open')
 *         ->wherePriority('high')
 *         ->orderByCreatedAt('desc')
 *         ->get();
 *
 * @template T of Model
 */
abstract class BaseQueryBuilder
{
    /**
     * The underlying Eloquent query builder instance.
     *
     * @var Builder<T>
     */
    protected Builder $query;

    /**
     * Create a new query builder instance.
     *
     * @param  Builder<T>|null  $query
     */
    public function __construct(?Builder $query = null)
    {
        $this->query = $query ?? $this->makeQuery();
    }

    /**
     * Get the model class this query builder is for.
     *
     * @return class-string<T>
     */
    abstract protected function getModel(): string;

    /**
     * Create a new query builder instance for the model.
     *
     * @return Builder<T>
     */
    protected function makeQuery(): Builder
    {
        $modelClass = $this->getModel();

        /** @var Builder<T> $query */
        $query = $modelClass::query();

        return $query;
    }

    /**
     * Get the underlying Eloquent query builder.
     *
     * @return Builder<T>
     */
    public function getQuery(): Builder
    {
        return $this->query;
    }

    /**
     * Apply a where condition to the query.
     *
     * @param  scalar|array<array-key, mixed>|object|null  $value  Valore bindable (scalar|array|DateTime|Enum|Stringable|null)
     */
    public function where(string $column, mixed $value): static
    {
        $this->query = $this->query->where($column, $value);

        return $this;
    }

    /**
     * Apply a where condition with operator to the query.
     *
     * @param  scalar|array<array-key, mixed>|object|null  $value  Valore bindable (scalar|array|DateTime|Enum|Stringable|null)
     */
    public function whereOperator(string $column, string $operator, mixed $value): static
    {
        $this->query = $this->query->where($column, $operator, $value);

        return $this;
    }

    /**
     * Apply a where in condition to the query.
     *
     * @param  array<mixed>  $values
     */
    public function whereIn(string $column, array $values): static
    {
        $this->query = $this->query->whereIn($column, $values);

        return $this;
    }

    /**
     * Apply a where not in condition to the query.
     *
     * @param  array<mixed>  $values
     */
    public function whereNotIn(string $column, array $values): static
    {
        $this->query = $this->query->whereNotIn($column, $values);

        return $this;
    }

    /**
     * Apply a where null condition to the query.
     */
    public function whereNull(string $column): static
    {
        $this->query = $this->query->whereNull($column);

        return $this;
    }

    /**
     * Apply a where not null condition to the query.
     */
    public function whereNotNull(string $column): static
    {
        $this->query = $this->query->whereNotNull($column);

        return $this;
    }

    /**
     * Apply a where between condition to the query.
     *
     * @param  array<int, mixed>  $values
     */
    public function whereBetween(string $column, array $values): static
    {
        $this->query = $this->query->whereBetween($column, $values);

        return $this;
    }

    /**
     * Order results by a column in ascending order.
     */
    public function orderBy(string $column, string $direction = 'asc'): static
    {
        if ($direction !== 'asc' && $direction !== 'desc') {
            $direction = 'asc';
        }

        $this->query = $this->query->orderBy($column, $direction);

        return $this;
    }

    /**
     * Order results by a column in descending order.
     */
    public function orderByDesc(string $column): static
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Limit the number of results.
     */
    public function limit(int $value): static
    {
        $this->query = $this->query->limit($value);

        return $this;
    }

    /**
     * Skip a number of results (offset).
     */
    public function skip(int $value): static
    {
        $this->query = $this->query->skip($value);

        return $this;
    }

    /**
     * Get eager loading relations.
     *
     * @param  array<string>  $relations
     */
    public function with(array $relations): static
    {
        $this->query = $this->query->with($relations);

        return $this;
    }

    /**
     * Eager load a single relation.
     */
    public function load(string $relation): static
    {
        return $this->with([$relation]);
    }

    /**
     * Get all results from the query.
     *
     * @return Collection<int, T>
     */
    public function get(): Collection
    {
        /** @var Collection<int, T> $results */
        $results = $this->query->get();

        return $results;
    }

    /**
     * Get the first result from the query.
     *
     * @return T|null
     */
    public function first(): ?Model
    {
        /* @var T|null */
        return $this->query->first();
    }

    /**
     * Get results with pagination.
     *
     * @return LengthAwarePaginator<int, T>
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        /* @var \Illuminate\Pagination\LengthAwarePaginator<int, T> */
        return $this->query->paginate($perPage);
    }

    /**
     * Get a count of results.
     */
    public function count(): int
    {
        return $this->query->count();
    }

    /**
     * Check if any results exist.
     */
    public function exists(): bool
    {
        return $this->query->exists();
    }

    /**
     * Check if no results exist.
     */
    public function doesntExist(): bool
    {
        return $this->query->doesntExist();
    }
}
