<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder as AdjacencyBuilder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Ancestors;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Bloodline;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Descendants;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\RootAncestor;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\RootAncestorOrSelf;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Relations\Siblings;

/**
 * Modules\Xot\Contracts\HasRecursiveRelationshipsContract.
 *
 * @property int               $id
 * @property string            $name
 * @property int               $depth
 * @property Collection<Model> $children
 * @property int|null          $children_count
 * @property Collection<Model> $ancestors                  The model's recursive parents.
 * @property int|null          $ancestors_count
 * @property Collection<Model> $ancestorsAndSelf           The model's recursive parents and itself.
 * @property int|null          $ancestors_and_self_count
 * @property Collection<Model> $bloodline                  The model's ancestors, descendants and itself.
 * @property int|null          $bloodline_count
 * @property Collection<Model> $childrenAndSelf            The model's direct children and itself.
 * @property int|null          $children_and_self_count
 * @property Collection<Model> $descendants                The model's recursive children.
 * @property int|null          $descendants_count
 * @property Collection<Model> $descendantsAndSelf         The model's recursive children and itself.
 * @property int|null          $descendants_and_self_count
 * @property Collection<Model> $parentAndSelf              The model's direct parent and itself.
 * @property int|null          $parent_and_self_count
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface HasRecursiveRelationshipsContract
{
    /**
     * Execute a query with a maximum depth constraint for the recursive query.
     */
    public static function withMaxDepth(int $maxDepth, callable $query): mixed;

    /**
     * Get the name of the parent key column.
     */
    public function getParentKeyName(): string;

    /**
     * Get the qualified parent key column.
     */
    public function getQualifiedParentKeyName(): string;

    /**
     * Get the name of the local key column.
     */
    public function getLocalKeyName(): string;

    /**
     * Get the qualified local key column.
     */
    public function getQualifiedLocalKeyName(): string;

    /**
     * Get the name of the depth column.
     */
    public function getDepthName(): string;

    /**
     * Get the name of the path column.
     */
    public function getPathName(): string;

    /**
     * Get the path separator.
     */
    public function getPathSeparator(): string;

    /**
     * Get the additional custom paths.
     *
     * @return array<string>
     */
    public function getCustomPaths(): array;

    /**
     * Get the name of the common table expression.
     */
    public function getExpressionName(): string;

    /**
     * Get the model's ancestors.
     */
    public function ancestors(): Ancestors;

    /**
     * Get the model's ancestors and itself.
     */
    public function ancestorsAndSelf(): Ancestors;

    /**
     * Get the model's bloodline.
     */
    public function bloodline(): Bloodline;

    /**
     * Get the model's children.
     */
    public function children(): HasMany;

    /**
     * Get the model's children and itself.
     */
    public function childrenAndSelf(): Descendants;

    /**
     * Get the model's descendants.
     */
    public function descendants(): Descendants;

    /**
     * Get the model's descendants and itself.
     */
    public function descendantsAndSelf(): Descendants;

    /**
     * Get the model's parent.
     */
    public function parent(): BelongsTo;

    /**
     * Get the model's parent and itself.
     */
    public function parentAndSelf(): Ancestors;

    /**
     * Get the model's root ancestor.
     */
    public function rootAncestor(): RootAncestor;

    /**
     * Get the model's root ancestor or self.
     */
    public function rootAncestorOrSelf(): RootAncestorOrSelf;

    /**
     * Get the model's siblings.
     */
    public function siblings(): Siblings;

    /**
     * Get the model's siblings and itself.
     */
    public function siblingsAndSelf(): Siblings;

    /**
     * Get the first segment of the model's path.
     */
    public function getFirstPathSegment(): string;

    /**
     * Determine whether the model's path is nested.
     */
    public function hasNestedPath(): bool;

    /**
     * Determine if an attribute is an integer.
     */
    public function isIntegerAttribute(string $attribute): bool;

    /**
     * Create a new Eloquent query builder for the model.
     */
    public function newEloquentBuilder(Builder $query): AdjacencyBuilder;

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param list<static> $models
     */
    public function newCollection(array $models = []): Collection;

    /**
     * added by XOT, viene utilizzato nelle options delle select.
     */
    public function getLabel(): string;
}
