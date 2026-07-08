<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\MessageFactory;
use Modules\Ptv\Models\Message as PtvMessageModel;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

/**
 * Modules\IndennitaResponsabilita\Models\Message.
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $title
 * @property string|null $txt
 * @property string|null $anno
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $parent_id
 * @property-read Collection<int, Message> $children
 * @property-read int|null $children_count
 * @property-read Message|null $parent
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Builder|Message breadthFirst()
 * @method static Builder|Message depthFirst()
 * @method static MessageFactory factory($count = null, $state = [])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Builder|Message getExpressionGrammar()
 * @method static Builder|Message hasChildren()
 * @method static Builder|Message hasParent()
 * @method static Builder|Message isLeaf()
 * @method static Builder|Message isRoot()
 * @method static Builder|Message newModelQuery()
 * @method static Builder|Message newQuery()
 * @method static Builder|Message query()
 * @method static Builder|Message tree($maxDepth = null)
 * @method static Builder|Message treeOf((Model|callable) $constraint, $maxDepth = null)
 * @method static Builder|Message whereAnno($value)
 * @method static Builder|Message whereCreatedAt($value)
 * @method static Builder|Message whereCreatedBy($value)
 * @method static Builder|Message whereDepth($operator, $value = null)
 * @method static Builder|Message whereId($value)
 * @method static Builder|Message whereParentId($value)
 * @method static Builder|Message whereTitle($value)
 * @method static Builder|Message whereTxt($value)
 * @method static Builder|Message whereType($value)
 * @method static Builder|Message whereUpdatedAt($value)
 * @method static Builder|Message whereUpdatedBy($value)
 * @method static Builder|Message withGlobalScopes(array $scopes)
 * @method static Builder|Message withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @property int|null $user_id
 * @property string|null $post_type
 * @property int|null $post_id
 * @property-read int $depth
 * @property-read string $path
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read \Modules\IndennitaResponsabilita\Models\Message|null $rootAncestor The model's topmost parent.
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read Collection<int, \Modules\IndennitaResponsabilita\Models\Message> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 * @method static Builder<static>|Message doesntHaveChildren()
 * @method static Builder<static>|Message wherePostId($value)
 * @method static Builder<static>|Message wherePostType($value)
 * @method static Builder<static>|Message whereUserId($value)
 * @method static Builder<static>|Message withGlobalScopes(array<int, string> $scopes)
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @mixin \Eloquent
 */
class Message extends PtvMessageModel
{
    protected $connection = 'indennita_responsabilita'; // this will use the specified database connection
}
