<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Ptv\Database\Factories\MessageFactory;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Collection;

/**
 * Modules\Ptv\Models\Message.
 *
 * @property Collection<int, Message> $children
 * @property int|null $children_count
 * @property mixed $type
 * @property Message|null $parent
 *
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
 * @method static Builder|Message whereDepth($operator, $value = null)
 * @method static Builder|Message withGlobalScopes(array<string, \Closure> $scopes)
 * @method static Builder|Message withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 *
 * @property-read Collection<int, Message> $ancestors The model's recursive parents.
 * @property-read int|null $ancestors_count
 * @property-read Collection<int, Message> $ancestorsAndSelf The model's recursive parents and itself.
 * @property-read int|null $ancestors_and_self_count
 * @property-read Collection<int, Message> $bloodline The model's ancestors, descendants and itself.
 * @property-read int|null $bloodline_count
 * @property-read Collection<int, Message> $childrenAndSelf The model's direct children and itself.
 * @property-read int|null $children_and_self_count
 * @property-read Collection<int, Message> $descendants The model's recursive children.
 * @property-read int|null $descendants_count
 * @property-read Collection<int, Message> $descendantsAndSelf The model's recursive children and itself.
 * @property-read int|null $descendants_and_self_count
 * @property-read Collection<int, Message> $parentAndSelf The model's direct parent and itself.
 * @property-read int|null $parent_and_self_count
 * @property-read Message|null $rootAncestor The model's topmost parent.
 * @property-read Collection<int, Message> $siblings The parent's other children.
 * @property-read int|null $siblings_count
 * @property-read Collection<int, Message> $siblingsAndSelf All the parent's children.
 * @property-read int|null $siblings_and_self_count
 *
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Builder|Message doesntHaveChildren()
 * @method static Collection<int, static> get($columns = ['*'])
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $title
 * @property string|null $txt
 * @property int|null $anno
 * @property string|null $post_type
 * @property int|null $post_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Builder|Message whereAnno($value)
 * @method static Builder|Message whereCreatedAt($value)
 * @method static Builder|Message whereCreatedBy($value)
 * @method static Builder|Message whereId($value)
 * @method static Builder|Message wherePostId($value)
 * @method static Builder|Message wherePostType($value)
 * @method static Builder|Message whereTitle($value)
 * @method static Builder|Message whereTxt($value)
 * @method static Builder|Message whereType($value)
 * @method static Builder|Message whereUpdatedAt($value)
 * @method static Builder|Message whereUpdatedBy($value)
 * @method static Builder|Message whereUserId($value)
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 *
 * @property int $depth
 * @property string $path
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Message extends BaseModel
{
    // protected $table = 'messages';
    // public $timestamps= false;
    protected $fillable =
        [
            'id',
            'parent_id',
            'type',
            'title',
            'txt',
            'anno',
        ];

    public function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'parent_id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // --- mutators ---
    public function getTypeAttribute(): string
    {
        $value = $this->attributes['type'] ?? '';
        if ($value === Str::slug((string) $value, '_')) {
            return $value;
        }

        $sluggedValue = Str::slug((string) $value, '_');
        $this->attributes['type'] = $sluggedValue;

        if ($this->getKey() !== null) {
            $this->update([
                'type' => $sluggedValue,
            ]);
        }

        return $sluggedValue;
    }
}
