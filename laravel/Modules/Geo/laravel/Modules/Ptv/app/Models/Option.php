<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\OptionFactory;
use Modules\Ptv\Enums\WorkerType;
use Override;
use Spatie\EloquentSortable\SortableTrait;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Modules\Performance\Models\Option.
 *
 * @property int $id
 * @property string|null $option_type
 * @property int|null $option_id
 * @property int|null $parent_id
 * @property int|null $pos
 * @property string|null $name
 * @property string|null $value
 * @property string|null $txt
 * @property string|null $txt1
 * @property int|null $year
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property Collection<int, Option> $sons
 * @property int|null $sons_count
 *
 * @method static Builder|Option newModelQuery()
 * @method static Builder|Option newQuery()
 * @method static Builder|Option query()
 * @method static Builder|Option whereCreatedAt($value)
 * @method static Builder|Option whereCreatedBy($value)
 * @method static Builder|Option whereId($value)
 * @method static Builder|Option whereName($value)
 * @method static Builder|Option whereOptionId($value)
 * @method static Builder|Option whereOptionType($value)
 * @method static Builder|Option whereParentId($value)
 * @method static Builder|Option wherePos($value)
 * @method static Builder|Option whereTxt($value)
 * @method static Builder|Option whereTxt1($value)
 * @method static Builder|Option whereUpdatedAt($value)
 * @method static Builder|Option whereUpdatedBy($value)
 * @method static Builder|Option whereValue($value)
 * @method static Builder|Option whereYear($value)
 *
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $children
 * @property-read int|null $children_count
 * @property-read Profile|null $creator
 * @property-read Option|null $parent
 * @property-read Profile|null $updater
 * @property-read int $depth
 * @property-read string $path
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read Option|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 *
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option doesntHaveChildren()
 * @method static OptionFactory factory($count = null, $state = [])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, static> get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option ordered(string $direction = 'asc')
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option treeOf((Model|callable) $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option withGlobalScopes(array<string, \Closure> $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 *
 * @property-read Profile|null $deleter
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $fillSons
 * @property-read int|null $fill_sons_count
 *
 * @mixin \Eloquent
 */
class Option extends BaseModel
{
    use HasRecursiveRelationships;
    use SortableTrait;

    /** @var array<string, string|bool> */
    public $sortable = [
        'order_column_name' => 'pos',
        'sort_when_creating' => true,
    ];

    /** @var list<string> */
    protected $fillable = [
        'id',
        'option_type', 'option_id',
        'name', 'value', 'year', 'txt', 'txt1',
        'parent_id', 'pos',
    ];

    /** @return array<string, string>  */
    #[Override]
    public function casts(): array
    {
        return [
            'option_type' => WorkerType::class,
        ];
    }

    public function attr(string $name): string
    {
        return 'preso';
    }

    /**
     * @return HasMany<static, static>
     */
    public function sons(): HasMany
    {
        // return $this->hasMany(static::class, 'parent_id', 'id');
        return $this->children();
    }

    /**
     * @return HasMany<static, static>
     */
    public function fillSons(): HasMany
    {
        $sons = $this->sons();
        if ($sons->count() == 0) {
            $pres = self::where('name', $this->name)->where('txt', $this->txt)->where('year', $this->year - 1)->first();
            if (is_iterable($pres?->sons)) {
                foreach ($pres->sons as $son) {
                    self::where('name', $son->name)->where('txt', $son->txt)->where('year', $this->year)->update(['parent_id' => $this->id]);
                }
            }
        }

        return $sons;
    }
}
