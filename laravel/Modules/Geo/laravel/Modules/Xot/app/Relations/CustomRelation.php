<?php

/**
 * ---.
 *
 * @see https://github.com/johnnyfreeman/laravel-custom-relation/blob/master/src/Relations/Custom.php
 */

declare(strict_types=1);

namespace Modules\Xot\Relations;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Webmozart\Assert\Assert;

/**
 * Class CustomRelation.
 *
 * @extends Relation<Model, Model, Collection<int, Model>>
 *
 * @method Builder<Model> when(mixed $value = null, ?callable $callback = null, ?callable $default = null)
 * @method Builder<Model> whereBetween(string $column, iterable<int, mixed> $values, string $boolean = 'and', bool $not = false)
 * @method Builder<Model> selectRaw(string $expression, array<int|string, mixed> $bindings = [])
 * @method Builder<Model> where(string|\Closure|\Illuminate\Contracts\Database\Query\Expression $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 */
class CustomRelation extends Relation
{
    /**
     * Create a new belongs to relationship instance.
     */
    public function __construct(
        Builder $query,
        Model $model,
        /* implements BuilderContract */
        /**
         * The baseConstraints callback.
         */
        protected \Closure $baseConstraints,
        /**
         * The eagerConstraints callback.
         */
        protected ?\Closure $eagerConstraints,
        /**
         * The eager constraints model matcher.
         */
        protected ?\Closure $eagerMatcher,
    ) {
        parent::__construct($query, $model);
    }

    /**
     * Set the base constraints on the relation query.
     */
    public function addConstraints(): void
    {
        \call_user_func($this->baseConstraints, $this);
    }

    /**
     * Set the constraints for an eager load of the relation.
     */
    /**
     * @param array<int, Model> $models
     */
    public function addEagerConstraints(array $models): void
    {
        // Parameter #1 $function of function call_user_func expects callable(): mixed, Closure|null given.
        if (! \is_callable($this->eagerConstraints)) {
            throw new Exception('eagerConstraints is not callable');
        }

        \call_user_func($this->eagerConstraints, $this, $models);
    }

    /**
     * Initialize the relation on a set of models.
     */
    /**
     * @param array<int, Model> $models
     *
     * @return array<int, Model>
     */
    public function initRelation(array $models, mixed $relation): array
    {
        if (! \is_string($relation)) {
            throw new Exception('relation is not a string');
        }

        foreach ($models as $model) {
            $model->setRelation($relation, $this->related->newCollection());
        }

        return $models;
    }

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @return array<int, Model>
     */
    /**
     * @param array<int, Model> $models
     * @param Collection<int, Model> $collection
     *
     * @return array<int, Model>
     */
    public function match(array $models, Collection $collection, mixed $relation): array
    {
        // Trying to invoke Closure|null but it might not be a callable.
        if (! \is_callable($this->eagerMatcher)) {
            throw new Exception('eagerMatcher is not callable');
        }

        $res = ($this->eagerMatcher)($models, $collection, $relation, $this);
        Assert::isArray($res);
        Assert::allIsInstanceOf($res, Model::class);

        /** @var array<int, Model> $models */
        $models = array_values($res);

        return $models;
    }

    /**
     * Get the results of the relationship.
     *
     * @return Collection<int, Model>
     */
    public function getResults(): Collection
    {
        return $this->get();
    }

    /**
     * Execute the query as a "select" statement.
     */
    /**
     * @param array<int, string>|string $columns
     *
     * @return Collection<int, Model>
     */
    public function get($columns = ['*']): Collection
    {
        // First we'll add the proper select columns onto the query so it is run with
        // the proper columns. Then, we will get the results and hydrate out pivot
        // models with the result of those columns as a separate model relation.
        $columns = $this->query->getQuery()->columns ? [] : $columns;
        if ($columns === ['*']) {
            $columns = [$this->related->getTable().'.*'];
        }

        $query = $this->query->applyScopes();
        $models = $query->addSelect($columns)->getModels();
        // If we actually found models we will also eager load any relationships that
        // have been specified as needing to be eager loaded. This will solve the
        // n + 1 query problem for the developer and also increase performance.
        if ((is_countable($models) ? \count($models) : 0) > 0) {
            $models = $query->eagerLoadRelations($models);
        }

        Assert::isArray($models);
        Assert::allIsInstanceOf($models, Model::class);

        /** @var array<int, Model> $models */
        return $this->related->newCollection($models);
    }

    /*
     * Add a basic where clause to the query.
     *
     * @param \Closure|string|array|\Illuminate\Database\Query\Expression $column
     * @param mixed                                                       $operator
     * @param mixed                                                       $value
     * @param string $boolean
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function where($column, $operator = null, $value = null, $boolean = 'and') {
    //    return $this->query->where($column, $operator, $value, $boolean);
    // }
}
