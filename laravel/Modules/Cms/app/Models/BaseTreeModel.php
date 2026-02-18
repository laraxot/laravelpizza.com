<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Cms\Database\Factories\MenuFactory;
use Modules\Media\Models\Media;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * Modules\Cms\Models\BaseTreeModel.
 *
 * @property int         $id
 * @property string      $name
 * @property array|null  $items
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder|Menu newModelQuery()
 * @method static Builder|Menu newQuery()
 * @method static Builder|Menu onlyTrashed()
 * @method static Builder|Menu query()
 * @method static Builder|Menu whereCreatedAt($value)
 * @method static Builder|Menu whereCreatedBy($value)
 * @method static Builder|Menu whereDeletedAt($value)
 * @method static Builder|Menu whereDeletedBy($value)
 * @method static Builder|Menu whereId($value)
 * @method static Builder|Menu whereItems($value)
 * @method static Builder|Menu whereName($value)
 * @method static Builder|Menu whereUpdatedAt($value)
 * @method static Builder|Menu whereUpdatedBy($value)
 * @method static Builder|Menu withTrashed()
 * @method static Builder|Menu withoutTrashed()
 *
 * @property string                      $title
 * @property int|null                    $parent_id
 * @property Collection|array<Menu>      $children
 * @property int|null                    $children_count
 * @property MediaCollection<int, Media> $media
 * @property int|null                    $media_count
 * @property Menu|null                   $parent
 * @property Collection|array<Menu>      $ancestors                  The model's recursive parents.
 * @property int|null                    $ancestors_count
 * @property Collection|array<Menu>      $ancestorsAndSelf           The model's recursive parents and itself.
 * @property int|null                    $ancestors_and_self_count
 * @property Collection|array<Menu>      $bloodline                  The model's ancestors, descendants and itself.
 * @property int|null                    $bloodline_count
 * @property Collection|array<Menu>      $childrenAndSelf            The model's direct children and itself.
 * @property int|null                    $children_and_self_count
 * @property Collection|array<Menu>      $descendants                The model's recursive children.
 * @property int|null                    $descendants_count
 * @property Collection|array<Menu>      $descendantsAndSelf         The model's recursive children and itself.
 * @property int|null                    $descendants_and_self_count
 * @property Collection|array<Menu>      $parentAndSelf              The model's direct parent and itself.
 * @property int|null                    $parent_and_self_count
 * @property Menu|null                   $rootAncestor               The model's topmost parent.
 * @property Collection|array<Menu>      $siblings                   The parent's other children.
 * @property int|null                    $siblings_count
 * @property Collection|array<Menu>      $siblingsAndSelf            All the parent's children.
 * @property int|null                    $siblings_and_self_count
 *
 * @method static Collection<int, static>                                 all($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu breadthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu depthFirst()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu doesntHaveChildren()
 * @method static Collection<int, static>                                 get($columns = ['*'])
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu getExpressionGrammar()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu hasChildren()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu hasParent()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu isLeaf()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu isRoot()
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu tree($maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu treeOf((Model|callable) $constraint, $maxDepth = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu whereDepth($operator, $value = null)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu whereParentId($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu withGlobalScopes(array $scopes)
 * @method static \Staudenmeir\LaravelAdjacencyList\Eloquent\Builder|Menu withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @method static Collection<int, static>                                 all($columns = ['*'])
 * @method static Collection<int, static>                                 get($columns = ['*'])
 * @method static Collection<int, static>                                 all($columns = ['*'])
 * @method static Collection<int, static>                                 get($columns = ['*'])
 * @method static Collection<int, static>                                 all($columns = ['*'])
 * @method static Collection<int, static>                                 get($columns = ['*'])
 * @method static Collection<int, static>                                 all($columns = ['*'])
 * @method static Collection<int, static>                                 get($columns = ['*'])
 * @method static Collection<int, static>                                 all($columns = ['*'])
 * @method static Collection<int, static>                                 get($columns = ['*'])
 * @method static Collection<int, static>                                 all($columns = ['*'])
 * @method static Collection<int, static>                                 get($columns = ['*'])
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static MenuFactory             factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
abstract class BaseTreeModel extends BaseModel implements HasRecursiveRelationshipsContract
{
    use HasRecursiveRelationships;

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

    #[\Override]
    public function getLabel(): string
    {
        return $this->title;
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
