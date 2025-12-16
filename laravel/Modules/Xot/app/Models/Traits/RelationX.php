<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

/**
 * Trait Modules\Xot\Models\Traits\RelationX.
 */
trait RelationX
{
    /**
     * @param  class-string<Model>  $related  Related model class
     * @param  class-string<Model>|string|null  $_table  Pivot table name
     * @param  string|null  $foreignPivotKey  Foreign pivot key
     * @param  string|null  $relatedPivotKey  Related pivot key
     * @param  string|null  $parentKey  Parent key
     * @param  string|null  $relatedKey  Related key
     * @param  string|null  $relation  Relation name
     */
    public function belongsToManyX(
        string $related,
        ?string $_table = null,
        ?string $foreignPivotKey = null,
        ?string $relatedPivotKey = null,
        ?string $parentKey = null,
        ?string $relatedKey = null,
        ?string $relation = null,
    ): BelongsToMany {
        Assert::isInstanceOf(
            $related_model = app($related),
            Model::class,
            '['.__LINE__.']['.class_basename($this).']',
        );
        $pivot = $this->guessPivot($related);
        $table = $pivot->getTable();
        $pivotFields = $pivot->getFillable();

        $pivotDbName = $pivot->getConnection()->getDatabaseName();
        $dbName = $this->getConnection()->getDatabaseName();
        $relatedDbName = $related_model->getConnection()->getDatabaseName();
        // if ($pivotDbName !== $dbName) {
        if ($pivotDbName !== $dbName || $relatedDbName !== $dbName) {
            $pivotDriver = $pivot->getConnection()->getDriverName();
            // Only add database prefix for non-SQLite drivers
            // SQLite doesn't support database.table syntax
            if ($pivotDriver !== 'sqlite') {
                $table = $pivotDbName.'.'.$table;
            }
        }
        // }

        return $this->belongsToMany(
            related: $related,
            table: $table,
            foreignPivotKey: $foreignPivotKey,
            relatedPivotKey: $relatedPivotKey,
            parentKey: $parentKey,
            relatedKey: $relatedKey,
            relation: $relation,
        )
            ->using($pivot::class)
            ->withPivot($pivotFields)
            ->withTimestamps();
    }

    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
     *
     * @param  class-string<TRelatedModel>  $related
     * @return MorphToMany<TRelatedModel, $this>
     */
    public function morphToManyX(
        string $related,
        string $name,
        ?string $_table = null,
        ?string $foreignPivotKey = null,
        ?string $relatedPivotKey = null,
        ?string $parentKey = null,
        ?string $relatedKey = null,
        ?string $relation = null,
        bool $inverse = false,
    ): MorphToMany {
        $pivot = $this->guessMorphPivot($related);
        $table = $pivot->getTable();
        $pivotFields = $pivot->getFillable();

        $pivotDbName = $pivot->getConnection()->getDatabaseName();
        $dbName = $this->getConnection()->getDatabaseName();
        // $relatedDbName = $related_model->getConnection()->getDatabaseName();
        if ($table === null) {
            $table = $pivot->getTable();
        }

        return $this->morphToMany(
            related: $related,
            name: $name,
            table: $table,
            foreignPivotKey: $foreignPivotKey,
            relatedPivotKey: $relatedPivotKey,
            parentKey: $parentKey,
            relatedKey: $relatedKey,
            relation: $relation,
            inverse: $inverse,
        )
            ->using($pivot::class)
            ->withPivot($pivotFields)
            ->withTimestamps();
    }

    public function guessMorphPivot(string $related, ?string $_class = null): MorphPivot
    {
        $class = $this::class;
        $pivot_name = class_basename($related).'Morph';

        $pivot_class = $this->guessPivotFullClass($pivot_name, $related, $class);
        $pivot = app($pivot_class);
        Assert::isInstanceOf($pivot, MorphPivot::class);

        return $pivot;
    }

    /**
     * Guess the pivot class for a many-to-many relationship.
     *
     * @param  string  $related  The related model class name
     * @param  string|class-string|null  $class  The class to use for parent class lookup (used internally)
     */
    public function guessPivot(string $related, ?string $class = null): Pivot
    {
        $class ??= $this::class;
        $model_names = [
            class_basename($class),
            class_basename($related),
        ];
        sort($model_names);
        $pivot_name = implode('', $model_names);

        $pivot_class = $this->guessPivotFullClass($pivot_name, $related, $class);

        $pivot = app($pivot_class);
        Assert::isInstanceOf($pivot, Pivot::class);

        return $pivot;
    }

    public function guessPivotFullClass(string $pivot_name, string $related, ?string $class = null): string
    {
        $class ??= $this::class;

        // Try class-based pivot first
        $pivot_class = $this->buildPivotClassName($class, $pivot_name);
        if (class_exists($pivot_class)) {
            return $pivot_class;
        }

        // Try related model-based pivot
        $pivot_class = $this->buildPivotClassName($related, $pivot_name);
        if (class_exists($pivot_class)) {
            return $pivot_class;
        }

        // Try parent class if available
        return $this->tryParentClassPivot($pivot_name, $related, $class);
    }

    private function buildPivotClassName(string $context, string $pivotName): string
    {
        return Str::of($context)
            ->beforeLast('\\')
            ->append('\\'.$pivotName)
            ->toString();
    }

    private function tryParentClassPivot(string $pivot_name, string $related, string $class): string
    {
        $parent_class = get_parent_class($class);
        if ($parent_class === false) {
            return $this->buildPivotClassName($class, $pivot_name);
        }

        // If parent class ends with 'Morph', use it directly
        if (Str::endsWith($parent_class, 'Morph')) {
            return $this->buildPivotClassName($class, $pivot_name);
        }

        // Otherwise, use parent class to build new pivot name
        $model_names = [
            class_basename($parent_class),
            class_basename($related),
        ];
        sort($model_names);
        $new_pivot_name = implode('', $model_names);

        return $this->guessPivotFullClass($new_pivot_name, $related, $parent_class);
    }
}
