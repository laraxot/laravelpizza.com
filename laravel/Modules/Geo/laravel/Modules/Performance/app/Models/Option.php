<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Performance\Database\Factories\OptionFactory;
use Modules\Ptv\Models\Option as PtvOption;
use Modules\Ptv\Models\Profile;

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
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $children
 * @property-read int|null $children_count
 * @property-read Profile|null $creator
 * @property-read \Modules\Performance\Models\Option|null $parent
 * @property-read Profile|null $updater
 * @property-read int $depth
 * @property-read string $path
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \Modules\Performance\Models\Option|null $rootAncestor The model's topmost parent.
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, \Modules\Performance\Models\Option> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
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
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option withGlobalScopes(array<int, mixed> $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder<static>|Option withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @property-read Profile|null $deleter
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Option> $fillSons
 * @property-read int|null $fill_sons_count
 * @mixin \Eloquent
 */
class Option extends PtvOption
{
    protected $connection = 'performance';
}
