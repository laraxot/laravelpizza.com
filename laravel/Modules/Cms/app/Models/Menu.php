<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Database\Factories\MenuFactory;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Actions\Tree\GetTreeOptionsByModelClassAction;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Contracts\ProfileContract;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Modules\Cms\Models\Menu.
 *
 * @property string $id
 * @property string|null $title
 * @property int|null $parent_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Collection<int, Menu> $children
 * @property int|null $children_count
 * @property ProfileContract|null $creator
 * @property Menu|null $parent
 * @property ProfileContract|null $updater
 * @property int $depth
 * @property string $path
 * @property Collection<int, Menu> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read Collection<int, Menu> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read Collection<int, Menu> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read Collection<int, Menu> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read Collection<int, Menu> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read Collection<int, Menu> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read Collection<int, Menu> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read Menu|null $rootAncestor The model's topmost parent.
 * @property-read Collection<int, Menu> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read Collection<int, Menu> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 *
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Builder<static>|Menu breadthFirst()
 * @method static Builder<static>|Menu depthFirst()
 * @method static Builder<static>|Menu doesntHaveChildren()
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Builder<static>|Menu getExpressionGrammar()
 * @method static Builder<static>|Menu hasChildren()
 * @method static Builder<static>|Menu hasParent()
 * @method static Builder<static>|Menu isLeaf()
 * @method static Builder<static>|Menu isRoot()
 * @method static Builder<static>|Menu newModelQuery()
 * @method static Builder<static>|Menu newQuery()
 * @method static Builder<static>|Menu query()
 * @method static Builder<static>|Menu tree($maxDepth = null)
 * @method static Builder<static>|Menu treeOf((Model|callable) $constraint, $maxDepth = null)
 * @method static Builder<static>|Menu whereCreatedAt($value)
 * @method static Builder<static>|Menu whereCreatedBy($value)
 * @method static Builder<static>|Menu whereDepth($operator, $value = null)
 * @method static Builder<static>|Menu whereId($value)
 * @method static Builder<static>|Menu whereParentId($value)
 * @method static Builder<static>|Menu whereTitle($value)
 * @method static Builder<static>|Menu whereUpdatedAt($value)
 * @method static Builder<static>|Menu whereUpdatedBy($value)
 * @method static Builder<static>|Menu whereDepth($operator, $value = null)
 * @method static Builder<static>|Menu withGlobalScopes(array $scopes)
 * @method static Builder<static>|Menu withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @method static static firstOrCreate(array $attributes, array $values = [])
 * @method static static create(array $attributes = [])
 * @method static static updateOrCreate(array $attributes, array $values = [])
 * @method static Builder<static>|Menu delete()
 * @method static Builder<static>|Menu where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Menu whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Menu whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Menu whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu whereNotBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Menu orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Menu latest($column = 'created_at')
 * @method static Builder<static>|Menu oldest($column = 'created_at')
 * @method static Builder<static>|Menu limit($value)
 * @method static Builder<static>|Menu take($value)
 * @method static Builder<static>|Menu skip($value)
 * @method static Builder<static>|Menu offset($value)
 * @method static int count()
 * @method static int max($column)
 * @method static int min($column)
 * @method static int sum($column)
 * @method static float avg($column)
 * @method static mixed pluck($column, $key = null)
 * @method static Builder<static>|Menu join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Menu orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Menu whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Menu whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Menu whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Menu whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Menu whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Menu with($relations)
 * @method static Builder<static>|Menu without($relations)
 * @method static Builder<static>|Menu withCount($relations)
 * @method static Builder<static>|Menu withSum($relation, $column)
 * @method static Builder<static>|Menu withAvg($relation, $column)
 * @method static Builder<static>|Menu withMin($relation, $column)
 * @method static Builder<static>|Menu withMax($relation, $column)
 * @method static Builder<static>|Menu findOrFail($id, $columns = ['*'])
 * @method static static findOrFail($id, $columns = ['*'])
 * @method static static firstOrFail($columns = ['*'])
 * @method static static update($attributes)
 * @method static int increment($column, $amount = 1, $extra = [])
 * @method static int decrement($column, $amount = 1, $extra = [])
 * @method static bool truncate()
 * @method static static destroy($ids)
 * @method static static restore()
 * @method static static forceDelete()
 * @method static static onlyTrashed()
 * @method static static withTrashed()
 * @method static static withoutTrashed()
 *
 * @property ProfileContract|null $deleter
 *
 * @method static MenuFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Menu extends BaseModel implements HasRecursiveRelationshipsContract
{
    use HasRecursiveRelationships;
    use SushiToJsons;

    /** @var list<string> */
    protected $fillable = [
        'title',
        'items',
        'parent_id',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'string',
        'parent_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    /**
     * @return array<int|string, string>
     */
    public static function getTreeMenuOptions(): array
    {
        /** @var class-string<HasRecursiveRelationshipsContract> $className */
        $className = self::class;

        return app(GetTreeOptionsByModelClassAction::class)->execute($className);
    }

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    #[\Override]
    public function getLabel(): string
    {
        // PHPStan Level 10: Ensure string return
        return $this->title ?? '';
    }

    /** @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'items' => 'array',
        ];
    }
}
