<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
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
 * @implements HasRecursiveRelationshipsContract<Model>
 *
 * @property string                $id
 * @property string|null           $title
 * @property int|null              $parent_id
 * @property string|null           $created_at
 * @property string|null           $updated_at
 * @property string|null           $created_by
 * @property string|null           $updated_by
 * @property Collection<int, Menu> $children
 * @property int|null              $children_count
 * @property ProfileContract|null  $creator
 * @property Menu|null             $parent
 * @property ProfileContract|null  $updater
 * @property int                   $depth
 * @property string                $path
 * @property Collection<int, Menu> $ancestors      The model's recursive parents.
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
 * @method static Builder<static>|Menu    breadthFirst()
 * @method static Builder<static>|Menu    depthFirst()
 * @method static Builder<static>|Menu    doesntHaveChildren()
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Builder<static>|Menu    getExpressionGrammar()
 * @method static Builder<static>|Menu    hasChildren()
 * @method static Builder<static>|Menu    hasParent()
 * @method static Builder<static>|Menu    isLeaf()
 * @method static Builder<static>|Menu    isRoot()
 * @method static Builder<static>|Menu    newModelQuery()
 * @method static Builder<static>|Menu    newQuery()
 * @method static Builder<static>|Menu    query()
 * @method static Builder<static>|Menu    tree($maxDepth = null)
 * @method static Builder<static>|Menu    treeOf(\Illuminate\Database\Eloquent\Model|callable $constraint, $maxDepth = null)
 * @method static Builder<static>|Menu    whereCreatedAt($value)
 * @method static Builder<static>|Menu    whereCreatedBy($value)
 * @method static Builder<static>|Menu    whereDepth($operator, $value = null)
 * @method static Builder<static>|Menu    whereId($value)
 * @method static Builder<static>|Menu    whereParentId($value)
 * @method static Builder<static>|Menu    whereTitle($value)
 * @method static Builder<static>|Menu    whereUpdatedAt($value)
 * @method static Builder<static>|Menu    whereUpdatedBy($value)
 * @method static Builder<static>|Menu    withGlobalScopes(array<string, mixed> $scopes)
 * @method static Builder<static>|Menu    withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
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

    /** @var array<string, string> */
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
        return app(GetTreeOptionsByModelClassAction::class)->execute(self::class);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    public function getLabel(): string
    {
        // PHPStan Level 10: Ensure string return
        return $this->title ?? '';
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'items' => 'array',
        ];
    }
}
