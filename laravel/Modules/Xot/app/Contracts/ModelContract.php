<?php

/**
 * @see https://github.com/buyersclub/laravel-eloquent-model-interface/blob/master/src/EloquentModelInterface.php
 */

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Modules\Xot\Contracts\ModelContract.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $post_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $title
 * @property bool $is_reclamed
 * @property bool $table_enable
 * @property Pivot|null $pivot
 * @property string $tennant_name
 *
 * @method mixed getKey()
 * @method string getRouteKey()
 * @method string getRouteKeyName()
 * @method string getTable()
 * @method mixed with($array)
 * @method array getFillable()
 * @method mixed fill($array)
 * @method mixed getConnection()
 * @method mixed update($params)
 * @method mixed delete()
 * @method mixed detach($params)
 * @method mixed attach($params)
 * @method array treeLabel()
 * @method array treeSons()
 * @method array toArray()
 * @method BelongsTo user()
 * @method mixed getAttributeValue(string $key)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface ModelContract
{
    /**
     * Save a new model and return the instance. Allow mass-assignment.
     *
     * @return Model|$this
     *
     * public function forceCreate(array $attributes);
     */

    /**
     * Duplicate the instance and unset all the loaded relations.
     *
     * @return $this
     */
    public function withoutRelations();

    /**
     * Fill the model with an array of attributes. Force mass assignment.
     *
     * @return $this
     */
    public function forceFill(array $attributes);

    /**
     * Save the model to the database.
     *
     * @return bool
     */
    public function save(array $options = []);

    /**
     * Convert the model instance to an array representation.
     *
     * @return array<mixed>
     */
    public function toArray();

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey();

    /**
     * Get a relationship.
     *
     * @param  string  $key
     *
     * @phpstan-param string $key
     *
     * @return mixed
     */
    public function getRelationValue($key);

    /**
     * Create a new instance of the given model.
     *
     * @param  array  $attributes
     * @param  bool  $exists
     * @return static
     */
    public function newInstance($attributes = [], $exists = false);

    /*
     * Add a basic where clause to the query.
     *
     * @param  \Closure|string|array|\Illuminate\Contracts\Database\Query\Expression  $column
     * @param  mixed  $operator
     * @param  mixed  $value
     * @param  string $boolean
     * @return $this
     *
     * public function where($column, $operator = null, $value = null, $boolean = 'and');
     */
    /*
     * Execute the query and get the first result or throw an exception.
     *
     * @param  array|string $columns
     * @return \Illuminate\Database\Eloquent\Model|static
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException<\Illuminate\Database\Eloquent\Model>
     *
     * public function firstOrFail($columns = ['*']);
     */
}
