<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace Modules\Activity\Models{
/**
 * Class Activity.
 * 
 * This class extends the BaseActivity model to represent activities in the application.
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string|null $causer_type
 * @property string|null $causer_id
 * @property array<string, mixed>|Collection<array-key, mixed>|null $properties
 * @property string|null $batch_uuid
 * @property string|null $event
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Model|null $causer
 * @property-read Collection $changes
 * @property-read Model|null $subject
 * @method static ActivityFactory factory($count = null, $state = [])
 * @method static Builder<static>|Activity forBatch(string $batchUuid)
 * @method static Builder<static>|Activity forEvent(string $event)
 * @method static Builder<static>|Activity forSubject(Model $subject)
 * @method static Builder<static>|Activity hasBatch()
 * @method static Builder<static>|Activity inLog(...$logNames)
 * @method static Builder<static>|Activity newModelQuery()
 * @method static Builder<static>|Activity newQuery()
 * @method static Builder<static>|Activity query()
 * @method static Builder<static>|Activity whereBatchUuid($value)
 * @method static Builder<static>|Activity whereCauserId($value)
 * @method static Builder<static>|Activity whereCauserType($value)
 * @method static Builder<static>|Activity whereCreatedAt($value)
 * @method static Builder<static>|Activity whereCreatedBy($value)
 * @method static Builder<static>|Activity whereDeletedAt($value)
 * @method static Builder<static>|Activity whereDeletedBy($value)
 * @method static Builder<static>|Activity whereDescription($value)
 * @method static Builder<static>|Activity whereEvent($value)
 * @method static Builder<static>|Activity whereId($value)
 * @method static Builder<static>|Activity whereLogName($value)
 * @method static Builder<static>|Activity whereProperties($value)
 * @method static Builder<static>|Activity whereSubjectId($value)
 * @method static Builder<static>|Activity whereSubjectType($value)
 * @method static Builder<static>|Activity whereUpdatedAt($value)
 * @method static Builder<static>|Activity whereUpdatedBy($value)
 * @method static Builder<static>|Activity where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Activity create(array $attributes = [])
 * @method static Builder<static>|Activity clone()
 * @method static Builder<static>|Activity selectRaw(string $expression)
 * @method static Builder<static>|Activity whereDate(string $column, string $operator, mixed $value = null)
 * @method static Builder<static>|Activity whereBetween(string $column, array $values)
 * @method static Builder<static>|Activity whereMonth(string $column, string $operator, mixed $value = null)
 * @method static Builder<static>|Activity whereYear(string $column, string $operator, mixed $value = null)
 * @method static Builder<static>|Activity latest(string $column = 'created_at')
 * @method static Builder<static>|Activity limit(int $value)
 * @method static Builder<static>|Activity with(array|string $relations)
 * @method static int sum(string $column)
 * @method static Collection<int, static>|Builder<static>|Activity get(array|string $columns = ['*'])
 * @method static static|null first(array|string $columns = ['*'])
 * @method static static find(mixed $id, array|string $columns = ['*'])
 * @method static static|null firstWhere(string $column, mixed $operator = null, mixed $value = null)
 * @method static Builder<static>|Activity orderBy(string $column, string $direction = 'asc')
 * @method static Builder<static>|Activity groupBy(array|string $groups)
 * @method static Builder<static>|Activity having(string $column, string $operator, mixed $value)
 * @method static Builder<static>|Activity orWhere(string $column, mixed $operator = null, mixed $value = null)
 * @method static Builder<static>|Activity whereIn(string $column, array $values)
 * @method static Builder<static>|Activity whereNotIn(string $column, array $values)
 * @method static Builder<static>|Activity whereNull(string $column)
 * @method static Builder<static>|Activity whereNotNull(string $column)
 * @method static int count(string $columns = '*')
 * @method static Collection<int, mixed> pluck(string $column, string|null $key = null)
 * @method static mixed max(string $column)
 * @method static mixed min(string $column)
 * @method static mixed avg(string $column)
 * @method static int sum(string $column)
 * @method static bool exists()
 * @method static bool doesntExist()
 * @method static Builder<static>|Activity distinct()
 * @method static Builder<static>|Activity join(string $table, string $first, string $operator = null, string $second = null)
 * @method static Builder<static>|Activity leftJoin(string $table, string $first, string $operator = null, string $second = null)
 * @method static Builder<static>|Activity rightJoin(string $table, string $first, string $operator = null, string $second = null)
 * @method static Builder<static>|Activity crossJoin(string $table)
 * @method static Builder<static>|Activity causedBy(Model $causer)
 * @mixin \Eloquent
 */
	class Activity extends \Eloquent {}
}

namespace Modules\Activity\Models{
/**
 * Modules\Activity\Models\Snapshot.
 *
 * @property int $id
 * @property string $aggregate_uuid
 * @property int $aggregate_version
 * @property array<array-key, mixed> $state
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder<static>|Snapshot newModelQuery()
 * @method static Builder<static>|Snapshot newQuery()
 * @method static Builder<static>|Snapshot query()
 * @method static Builder<static>|Snapshot uuid(string $uuid)
 * @method static Builder<static>|Snapshot whereAggregateUuid($value)
 * @method static Builder<static>|Snapshot whereAggregateVersion($value)
 * @method static Builder<static>|Snapshot whereCreatedAt($value)
 * @method static Builder<static>|Snapshot whereCreatedBy($value)
 * @method static Builder<static>|Snapshot whereId($value)
 * @method static Builder<static>|Snapshot whereState($value)
 * @method static Builder<static>|Snapshot whereUpdatedAt($value)
 * @method static Builder<static>|Snapshot whereUpdatedBy($value)
 * @method static SnapshotFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Snapshot extends \Eloquent {}
}

namespace Modules\Activity\Models{
/**
 * Class StoredEvent.
 * 
 * Represents a stored event in the activity module.
 *
 * @property int $id
 * @property string|null $aggregate_uuid
 * @property int|null $aggregate_version
 * @property int $event_version
 * @property string $event_class
 * @property array<array-key, mixed> $event_properties
 * @property SchemalessAttributes $meta_data
 * @property string $created_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read ShouldBeStored|null $event
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent afterVersion(int $version)
 * @method static EloquentStoredEventCollection<static> all($columns = ['*'])
 * @method static EloquentStoredEventCollection<static> get($columns = ['*'])
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent lastEvent(string ...$eventClasses)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent newModelQuery()
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent newQuery()
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent query()
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent startingFrom(int $storedEventId)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateRoot(string $uuid)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateUuid($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereAggregateVersion($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereCreatedAt($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereCreatedBy($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereEvent(string ...$eventClasses)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventClass($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventProperties($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereEventVersion($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereId($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereMetaData($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent wherePropertyIs(string $property, ?mixed $value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent wherePropertyIsNot(string $property, ?mixed $value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereUpdatedBy($value)
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent withMetaDataAttributes()
 * @method static StoredEventFactory factory($count = null, $state = [])
 * @property string|null $updated_at
 * @method static EloquentStoredEventQueryBuilder<static>|StoredEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class StoredEvent extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * ---.
 *
 * @property string                       $id
 * @property array<array-key, mixed>|null $title
 * @property array<array-key, mixed>|null $description
 * @property string|null                  $slug
 * @property string|null                  $disk
 * @property array<array-key, mixed>|null $attachment
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property ProfileContract|null         $creator
 * @property MediaCollection<int, Media>  $media
 * @property int|null                     $media_count
 * @property mixed                        $translations
 * @property ProfileContract|null         $updater
 * @method static Builder<static>|Attachment newModelQuery()
 * @method static Builder<static>|Attachment newQuery()
 * @method static Builder<static>|Attachment query()
 * @method static Builder<static>|Attachment whereAttachment($value)
 * @method static Builder<static>|Attachment whereCreatedAt($value)
 * @method static Builder<static>|Attachment whereCreatedBy($value)
 * @method static Builder<static>|Attachment whereDescription($value)
 * @method static Builder<static>|Attachment whereDisk($value)
 * @method static Builder<static>|Attachment whereId($value)
 * @method static Builder<static>|Attachment whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Attachment whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Attachment whereLocale(string $column, string $locale)
 * @method static Builder<static>|Attachment whereLocales(string $column, array $locales)
 * @method static Builder<static>|Attachment whereSlug($value)
 * @method static Builder<static>|Attachment whereTitle($value)
 * @method static Builder<static>|Attachment whereUpdatedAt($value)
 * @method static Builder<static>|Attachment whereUpdatedBy($value)
 * @method static static|null                firstWhere(string $column, mixed $operator = null, mixed $value = null)
 * @property ProfileContract|null $deleter
 * @method static AttachmentFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Attachment extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Conf.
 *
 * @property int         $id
 * @property string|null $name
 * @method static Builder<static>|Conf newModelQuery()
 * @method static Builder<static>|Conf newQuery()
 * @method static Builder<static>|Conf query()
 * @method static Builder<static>|Conf whereId($value)
 * @method static Builder<static>|Conf whereName($value)
 * @method static int                  count()
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 * @method static ConfFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Conf extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Menu.
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
 * @method static Builder<static>|Menu    treeOf((Model|callable) $constraint, $maxDepth = null)
 * @method static Builder<static>|Menu    whereCreatedAt($value)
 * @method static Builder<static>|Menu    whereCreatedBy($value)
 * @method static Builder<static>|Menu    whereDepth($operator, $value = null)
 * @method static Builder<static>|Menu    whereId($value)
 * @method static Builder<static>|Menu    whereParentId($value)
 * @method static Builder<static>|Menu    whereTitle($value)
 * @method static Builder<static>|Menu    whereUpdatedAt($value)
 * @method static Builder<static>|Menu    whereUpdatedBy($value)
 * @method static Builder<static>|Menu    whereDepth($operator, $value = null)
 * @method static Builder<static>|Menu    withGlobalScopes(array $scopes)
 * @method static Builder<static>|Menu    withRelationshipExpression($direction, callable $constraint, $initialDepth, $from = null, $maxDepth = null)
 * @method static static                  firstOrCreate(array $attributes, array $values = [])
 * @method static static                  create(array $attributes = [])
 * @method static static                  updateOrCreate(array $attributes, array $values = [])
 * @method static Builder<static>|Menu    delete()
 * @method static Builder<static>|Menu    where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Menu    whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu    whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Menu    whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu    whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Menu    whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu    whereNotBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu    whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu    whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu    whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu    whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu    whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Menu    whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Menu    orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Menu    latest($column = 'created_at')
 * @method static Builder<static>|Menu    oldest($column = 'created_at')
 * @method static Builder<static>|Menu    limit($value)
 * @method static Builder<static>|Menu    take($value)
 * @method static Builder<static>|Menu    skip($value)
 * @method static Builder<static>|Menu    offset($value)
 * @method static int                     count()
 * @method static int                     max($column)
 * @method static int                     min($column)
 * @method static int                     sum($column)
 * @method static float                   avg($column)
 * @method static mixed                   pluck($column, $key = null)
 * @method static Builder<static>|Menu    join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu    leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu    rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu    crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Menu    having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Menu    orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Menu    whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu    whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu    whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Menu    whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Menu    whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Menu    whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Menu    whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Menu    whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Menu    with($relations)
 * @method static Builder<static>|Menu    without($relations)
 * @method static Builder<static>|Menu    withCount($relations)
 * @method static Builder<static>|Menu    withSum($relation, $column)
 * @method static Builder<static>|Menu    withAvg($relation, $column)
 * @method static Builder<static>|Menu    withMin($relation, $column)
 * @method static Builder<static>|Menu    withMax($relation, $column)
 * @method static Builder<static>|Menu    findOrFail($id, $columns = ['*'])
 * @method static static                  findOrFail($id, $columns = ['*'])
 * @method static static                  firstOrFail($columns = ['*'])
 * @method static static                  update($attributes)
 * @method static int                     increment($column, $amount = 1, $extra = [])
 * @method static int                     decrement($column, $amount = 1, $extra = [])
 * @method static bool                    truncate()
 * @method static static                  destroy($ids)
 * @method static static                  restore()
 * @method static static                  forceDelete()
 * @method static static                  onlyTrashed()
 * @method static static                  withTrashed()
 * @method static static                  withoutTrashed()
 * @property ProfileContract|null $deleter
 * @method static MenuFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Menu extends \Eloquent implements \Modules\Xot\Contracts\HasRecursiveRelationshipsContract {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Module.
 *
 * @property string               $id
 * @property string|null          $name
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Module newModelQuery()
 * @method static Builder<static>|Module newQuery()
 * @method static Builder<static>|Module query()
 * @method static Builder<static>|Module whereId($value)
 * @method static Builder<static>|Module whereName($value)
 * @method static int                    count()
 * @property ProfileContract|null $deleter
 * @method static ModuleFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Module extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Page.
 *
 * @property string                       $id
 * @property array<array-key, mixed>|null $title
 * @property string|null                  $slug
 * @property array<array-key, mixed>|null $middleware
 * @property string|null                  $content
 * @property string|null                  $description
 * @property array<array-key, mixed>|null $content_blocks
 * @property array<array-key, mixed>|null $sidebar_blocks
 * @property array<array-key, mixed>|null $footer_blocks
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property ProfileContract|null         $creator
 * @property mixed                        $translations
 * @property ProfileContract|null         $updater
 * @method static Builder<static>|Page    newModelQuery()
 * @method static Builder<static>|Page    newQuery()
 * @method static Builder<static>|Page    query()
 * @method static Builder<static>|Page    whereContent($value)
 * @method static Builder<static>|Page    whereContentBlocks($value)
 * @method static Builder<static>|Page    whereCreatedAt($value)
 * @method static Builder<static>|Page    whereCreatedBy($value)
 * @method static Builder<static>|Page    whereDescription($value)
 * @method static Builder<static>|Page    whereFooterBlocks($value)
 * @method static Builder<static>|Page    whereId($value)
 * @method static Builder<static>|Page    whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page    whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Page    whereLocale(string $column, string $locale)
 * @method static Builder<static>|Page    whereLocales(string $column, array $locales)
 * @method static Builder<static>|Page    whereMiddleware($value)
 * @method static Builder<static>|Page    whereSidebarBlocks($value)
 * @method static Builder<static>|Page    whereSlug($value)
 * @method static Builder<static>|Page    whereTitle($value)
 * @method static Builder<static>|Page    whereUpdatedAt($value)
 * @method static Builder<static>|Page    whereUpdatedBy($value)
 * @method static Builder<static>|Page    where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static static|null             first(array|string $columns = ['*'])
 * @method static static|null             firstWhere(string $column, mixed $operator = null, mixed $value = null)
 * @method static static                  firstOrCreate(array $attributes, array $values = [])
 * @method static static                  create(array $attributes = [])
 * @method static static                  updateOrCreate(array $attributes, array $values = [])
 * @method static Builder<static>|Page    delete()
 * @method static Builder<static>|Page    whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page    whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page    whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page    orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page    latest($column = 'created_at')
 * @method static Builder<static>|Page    oldest($column = 'created_at')
 * @method static Builder<static>|Page    limit($value)
 * @method static Builder<static>|Page    take($value)
 * @method static Builder<static>|Page    skip($value)
 * @method static Builder<static>|Page    offset($value)
 * @method static int                     count()
 * @method static int                     max($column)
 * @method static int                     min($column)
 * @method static int                     sum($column)
 * @method static float                   avg($column)
 * @method static mixed                   pluck($column, $key = null)
 * @method static Builder<static>|Page    join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page    with($relations)
 * @method static Builder<static>|Page    without($relations)
 * @method static Builder<static>|Page    withCount($relations)
 * @method static Builder<static>|Page    withSum($relation, $column)
 * @method static Builder<static>|Page    withAvg($relation, $column)
 * @method static Builder<static>|Page    withMin($relation, $column)
 * @method static Builder<static>|Page    withMax($relation, $column)
 * @method static Builder<static>|Page    findOrFail($id, $columns = ['*'])
 * @method static static                  findOrFail($id, $columns = ['*'])
 * @method static static                  firstOrFail($columns = ['*'])
 * @method static static                  firstOrCreate(array $attributes, array $values = [])
 * @method static static                  create(array $attributes = [])
 * @method static static                  updateOrCreate(array $attributes, array $values = [])
 * @method static static                  update($attributes)
 * @method static Builder<static>|Page    where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    whereIn($column, $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotIn($column, $values, $boolean = 'and')
 * @method static Builder<static>|Page    whereNull($columns, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotNull($columns, $boolean = 'and')
 * @method static Builder<static>|Page    whereBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotBetween($column, array $values, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereDate($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereMonth($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereDay($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereYear($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereTime($column, string $operator, string $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereColumn($column, string $operator, mixed $value, $boolean = 'and')
 * @method static Builder<static>|Page    orderBy($column, $direction = 'asc')
 * @method static Builder<static>|Page    latest($column = 'created_at')
 * @method static Builder<static>|Page    oldest($column = 'created_at')
 * @method static Builder<static>|Page    limit($value)
 * @method static Builder<static>|Page    take($value)
 * @method static Builder<static>|Page    skip($value)
 * @method static Builder<static>|Page    offset($value)
 * @method static int                     count()
 * @method static int                     max($column)
 * @method static int                     min($column)
 * @method static int                     sum($column)
 * @method static float                   avg($column)
 * @method static mixed                   pluck($column, $key = null)
 * @method static Builder<static>|Page    join($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    leftJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    rightJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    crossJoin($table, $first, $operator = null, $second = null)
 * @method static Builder<static>|Page    having($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    orWhere($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder<static>|Page    whereExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereNotExists($callback, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereHas($relation, $operator = '>=', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereDoesntHave($relation, $operator = '<', $count = 1, $boolean = 'and', $callback = null)
 * @method static Builder<static>|Page    whereJsonContains($column, mixed $value, $boolean = 'and', $not = false)
 * @method static Builder<static>|Page    whereJsonLength($column, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonPath($path, $operator, $value, $boolean = 'and')
 * @method static Builder<static>|Page    whereJsonOverlaps($column, $value, $boolean = 'and')
 * @method static Builder<static>|Page    with($relations)
 * @method static Builder<static>|Page    without($relations)
 * @method static Builder<static>|Page    withCount($relations)
 * @method static Builder<static>|Page    withSum($relation, $column)
 * @method static Builder<static>|Page    withAvg($relation, $column)
 * @method static Builder<static>|Page    withMin($relation, $column)
 * @method static Builder<static>|Page    withMax($relation, $column)
 * @method static Builder<static>|Page    findOrFail($id, $columns = ['*'])
 * @method static static                  findOrFail($id, $columns = ['*'])
 * @method static static                  firstOrFail($columns = ['*'])
 * @method static static                  firstOrCreate(array $attributes, array $values = [])
 * @method static static                  create(array $attributes = [])
 * @method static static                  updateOrCreate(array $attributes, array $values = [])
 * @method static static                  update($attributes)
 * @method static int                     increment($column, $amount = 1, $extra = [])
 * @method static int                     decrement($column, $amount = 1, $extra = [])
 * @method static bool                    truncate()
 * @method static static                  destroy($ids)
 * @method static static                  restore()
 * @method static static                  forceDelete()
 * @method static static                  onlyTrashed()
 * @method static static                  withTrashed()
 * @method static static                  withoutTrashed()
 * @method static Collection<int, static> all($columns = ['*'])
 * @method static Collection<int, static> get($columns = ['*'])
 * @method static static|null             first($columns = ['*'])
 * @method static static|null             find($id, $columns = ['*'])
 * @property ProfileContract|null $deleter
 * @method static PageFactory factory($count = null, $state = [])
 * @property array<array-key, mixed>|null $blocks
 * @method static Builder<static>|Page whereBlocks($value)
 * @mixin \Eloquent
 */
	class Page extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\PageContent.
 *
 * @property string                       $id
 * @property array<array-key, mixed>|null $name
 * @property string|null                  $slug
 * @property array<array-key, mixed>|null $blocks
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property ProfileContract|null         $creator
 * @property mixed                        $translations
 * @property ProfileContract|null         $updater
 * @method static Builder<static>|PageContent newModelQuery()
 * @method static Builder<static>|PageContent newQuery()
 * @method static Builder<static>|PageContent query()
 * @method static Builder<static>|PageContent whereBlocks($value)
 * @method static Builder<static>|PageContent whereCreatedAt($value)
 * @method static Builder<static>|PageContent whereCreatedBy($value)
 * @method static Builder<static>|PageContent whereId($value)
 * @method static Builder<static>|PageContent whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|PageContent whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|PageContent whereLocale(string $column, string $locale)
 * @method static Builder<static>|PageContent whereLocales(string $column, array $locales)
 * @method static Builder<static>|PageContent whereName($value)
 * @method static Builder<static>|PageContent whereSlug($value)
 * @method static Builder<static>|PageContent whereUpdatedAt($value)
 * @method static Builder<static>|PageContent whereUpdatedBy($value)
 * @method static int                         count()
 * @property ProfileContract|null $deleter
 * @method static PageContentFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class PageContent extends \Eloquent {}
}

namespace Modules\Cms\Models{
/**
 * Modules\Cms\Models\Section.
 *
 * @property string                       $id
 * @property array<array-key, mixed>|null $name
 * @property string|null                  $slug
 * @property array<array-key, mixed>|null $blocks
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property ProfileContract|null         $creator
 * @property mixed                        $translations
 * @property ProfileContract|null         $updater
 * @method static Builder<static>|Section newModelQuery()
 * @method static Builder<static>|Section newQuery()
 * @method static Builder<static>|Section query()
 * @method static Builder<static>|Section whereBlocks($value)
 * @method static Builder<static>|Section whereCreatedAt($value)
 * @method static Builder<static>|Section whereCreatedBy($value)
 * @method static Builder<static>|Section whereId($value)
 * @method static Builder<static>|Section whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Section whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Section whereLocale(string $column, string $locale)
 * @method static Builder<static>|Section whereLocales(string $column, array $locales)
 * @method static Builder<static>|Section whereName($value)
 * @method static Builder<static>|Section whereSlug($value)
 * @method static Builder<static>|Section whereUpdatedAt($value)
 * @method static Builder<static>|Section whereUpdatedBy($value)
 * @method static int                     count()
 * @method static Builder<static>|Section where($column, $operator = null, $value = null, $boolean = 'and')
 * @property ProfileContract|null $deleter
 * @method static SectionFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Section extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Consent.
 *
 * @property string               $id
 * @property string|null          $treatment_id
 * @property string|null          $subject_id
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @property string               $user_type
 * @property string|null          $user_id
 * @property string|null          $type
 * @property string|null          $accepted_at
 * @property ProfileContract|null $creator
 * @property Treatment|null       $treatment
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Consent newModelQuery()
 * @method static Builder<static>|Consent newQuery()
 * @method static Builder<static>|Consent query()
 * @method static Builder<static>|Consent whereAcceptedAt($value)
 * @method static Builder<static>|Consent whereCreatedAt($value)
 * @method static Builder<static>|Consent whereCreatedBy($value)
 * @method static Builder<static>|Consent whereDeletedAt($value)
 * @method static Builder<static>|Consent whereDeletedBy($value)
 * @method static Builder<static>|Consent whereId($value)
 * @method static Builder<static>|Consent whereSubjectId($value)
 * @method static Builder<static>|Consent whereTreatmentId($value)
 * @method static Builder<static>|Consent whereType($value)
 * @method static Builder<static>|Consent whereUpdatedAt($value)
 * @method static Builder<static>|Consent whereUpdatedBy($value)
 * @method static Builder<static>|Consent whereUserId($value)
 * @method static Builder<static>|Consent whereUserType($value)
 * @property ProfileContract|null $deleter
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @method static \Modules\Gdpr\Database\Factories\ConsentFactory factory($count = null, $state = [])
 * @method static Builder<static>|Consent whereIpAddress($value)
 * @method static Builder<static>|Consent whereUserAgent($value)
 * @mixin \Eloquent
 */
	class Consent extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Event.
 *
 * @property string               $id
 * @property string|null          $treatment_id
 * @property string|null          $consent_id
 * @property string               $subject_id
 * @property string               $ip
 * @property string               $action
 * @property string               $payload
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @property Consent|null         $consent
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Event newModelQuery()
 * @method static Builder<static>|Event newQuery()
 * @method static Builder<static>|Event query()
 * @method static Builder<static>|Event whereAction($value)
 * @method static Builder<static>|Event whereConsentId($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereCreatedBy($value)
 * @method static Builder<static>|Event whereDeletedAt($value)
 * @method static Builder<static>|Event whereDeletedBy($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereIp($value)
 * @method static Builder<static>|Event wherePayload($value)
 * @method static Builder<static>|Event whereSubjectId($value)
 * @method static Builder<static>|Event whereTreatmentId($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event whereUpdatedBy($value)
 * @property ProfileContract|null $deleter
 * @method static \Modules\Gdpr\Database\Factories\EventFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Event extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Profile.
 *
 * @property string                                                    $id
 * @property string|null                                               $post_type
 * @property string|null                                               $bio
 * @property Carbon|null                                               $created_at
 * @property Carbon|null                                               $updated_at
 * @property string|null                                               $created_by
 * @property string|null                                               $updated_by
 * @property string|null                                               $deleted_by
 * @property string|null                                               $first_name
 * @property string|null                                               $surname
 * @property string|null                                               $email
 * @property string|null                                               $phone
 * @property string|null                                               $address
 * @property string|null                                               $user_id
 * @property string|null                                               $last_name
 * @property string|null                                               $tax_code
 * @property string|null                                               $vat_number
 * @property Carbon|null                                               $deleted_at
 * @property SchemalessAttributes                                      $extra
 * @property string                                                    $avatar
 * @property ProfileContract|null                                      $creator
 * @property Collection<int, DeviceUser>                               $deviceUsers
 * @property int|null                                                  $device_users_count
 * @property DeviceProfile|null                                        $pivot
 * @property Collection<int, Device>                                   $devices
 * @property int|null                                                  $devices_count
 * @property string|null                                               $full_name
 * @property MediaCollection<int, Media>                               $media
 * @property int|null                                                  $media_count
 * @property Collection<int, DeviceUser>                               $mobileDeviceUsers
 * @property int|null                                                  $mobile_device_users_count
 * @property Collection<int, Device>                                   $mobileDevices
 * @property int|null                                                  $mobile_devices_count
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property int|null                                                  $notifications_count
 * @property Collection<int, Permission>                               $permissions
 * @property int|null                                                  $permissions_count
 * @property Collection<int, Role>                                     $roles
 * @property int|null                                                  $roles_count
 * @property ProfileContract|null                                      $updater
 * @property User|null                                                 $user
 * @property string|null                                               $user_name
 * @method static Builder<static>|Profile newModelQuery()
 * @method static Builder<static>|Profile newQuery()
 * @method static Builder<static>|Profile permission($permissions, $without = false)
 * @method static Builder<static>|Profile query()
 * @method static Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static Builder<static>|Profile whereAddress($value)
 * @method static Builder<static>|Profile whereBio($value)
 * @method static Builder<static>|Profile whereCreatedAt($value)
 * @method static Builder<static>|Profile whereCreatedBy($value)
 * @method static Builder<static>|Profile whereDeletedAt($value)
 * @method static Builder<static>|Profile whereDeletedBy($value)
 * @method static Builder<static>|Profile whereEmail($value)
 * @method static Builder<static>|Profile whereFirstName($value)
 * @method static Builder<static>|Profile whereId($value)
 * @method static Builder<static>|Profile whereLastName($value)
 * @method static Builder<static>|Profile wherePhone($value)
 * @method static Builder<static>|Profile wherePostType($value)
 * @method static Builder<static>|Profile whereSurname($value)
 * @method static Builder<static>|Profile whereTaxCode($value)
 * @method static Builder<static>|Profile whereUpdatedAt($value)
 * @method static Builder<static>|Profile whereUpdatedBy($value)
 * @method static Builder<static>|Profile whereUserId($value)
 * @method static Builder<static>|Profile whereVatNumber($value)
 * @method static Builder<static>|Profile withExtraAttributes()
 * @method static Builder<static>|Profile withoutPermission($permissions)
 * @method static Builder<static>|Profile withoutRole($roles, $guard = null)
 * @property ProfileContract|null $deleter
 * @property string|null $fiscal_code
 * @property string|null $notes
 * @method static Builder<static>|Profile childrenWith(array $relations)
 * @method static Builder<static>|Profile childrenWithCount(array $relations)
 * @method static \Modules\Gdpr\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static Builder<static>|Profile whereFiscalCode($value)
 * @method static Builder<static>|Profile whereNotes($value)
 * @mixin \Eloquent
 */
	class Profile extends \Eloquent {}
}

namespace Modules\Gdpr\Models{
/**
 * Modules\Gdpr\Models\Treatment.
 *
 * @property string               $id
 * @property int                  $active
 * @property int                  $required
 * @property string               $name
 * @property string               $description
 * @property string|null          $documentVersion
 * @property string|null          $documentUrl
 * @property int                  $weight
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Treatment newModelQuery()
 * @method static Builder<static>|Treatment newQuery()
 * @method static Builder<static>|Treatment query()
 * @method static Builder<static>|Treatment whereActive($value)
 * @method static Builder<static>|Treatment whereCreatedAt($value)
 * @method static Builder<static>|Treatment whereCreatedBy($value)
 * @method static Builder<static>|Treatment whereDeletedAt($value)
 * @method static Builder<static>|Treatment whereDeletedBy($value)
 * @method static Builder<static>|Treatment whereDescription($value)
 * @method static Builder<static>|Treatment whereDocumentUrl($value)
 * @method static Builder<static>|Treatment whereDocumentVersion($value)
 * @method static Builder<static>|Treatment whereId($value)
 * @method static Builder<static>|Treatment whereName($value)
 * @method static Builder<static>|Treatment whereRequired($value)
 * @method static Builder<static>|Treatment whereUpdatedAt($value)
 * @method static Builder<static>|Treatment whereUpdatedBy($value)
 * @method static Builder<static>|Treatment whereWeight($value)
 * @property ProfileContract|null $deleter
 * @method static \Modules\Gdpr\Database\Factories\TreatmentFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Treatment extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * Class Address.
 * 
 * Implementazione di Schema.org PostalAddress
 *
 * @property int                          $id
 * @property string|null                  $model_type
 * @property string|null                  $model_id
 * @property string|null                  $name                        Nome identificativo dell'indirizzo
 * @property string|null                  $description                 Descrizione opzionale
 * @property string|null                  $route                       Via/Piazza
 * @property string|null                  $street_number               Numero civico
 * @property string|null                  $locality                    Comune/Città
 * @property string|null                  $administrative_area_level_3 Provincia
 * @property string|null                  $administrative_area_level_2 Regione
 * @property string|null                  $administrative_area_level_1 Stato/Paese
 * @property string|null                  $country                     Codice paese ISO
 * @property string|null                  $postal_code                 CAP
 * @property string|null                  $formatted_address
 * @property string|null                  $place_id                    ID Google Places
 * @property float|null                   $latitude
 * @property float|null                   $longitude
 * @property AddressTypeEnum|null         $type                        Tipo indirizzo (home, work, etc.)
 * @property bool                         $is_primary
 * @property array<array-key, mixed>|null $extra_data
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $updated_by
 * @property string|null                  $created_by
 * @property string|null                  $deleted_at
 * @property string|null                  $deleted_by
 * @property Model|\Eloquent|null         $addressable
 * @property ProfileContract|null         $creator
 * @property string                       $full_address
 * @property string                       $street_address
 * @property Model|\Eloquent|null         $model
 * @property ProfileContract|null         $updater
 * @method static Builder<static>|Address nearby(float $latitude, float $longitude, float $radiusKm = 10)
 * @method static Builder<static>|Address newModelQuery()
 * @method static Builder<static>|Address newQuery()
 * @method static Builder<static>|Address ofType($type)
 * @method static Builder<static>|Address primary()
 * @method static Builder<static>|Address query()
 * @method static Builder<static>|Address whereAdministrativeAreaLevel1($value)
 * @method static Builder<static>|Address whereAdministrativeAreaLevel2($value)
 * @method static Builder<static>|Address whereAdministrativeAreaLevel3($value)
 * @method static Builder<static>|Address whereCountry($value)
 * @method static Builder<static>|Address whereCreatedAt($value)
 * @method static Builder<static>|Address whereCreatedBy($value)
 * @method static Builder<static>|Address whereDeletedAt($value)
 * @method static Builder<static>|Address whereDeletedBy($value)
 * @method static Builder<static>|Address whereDescription($value)
 * @method static Builder<static>|Address whereExtraData($value)
 * @method static Builder<static>|Address whereFormattedAddress($value)
 * @method static Builder<static>|Address whereId($value)
 * @method static Builder<static>|Address whereIsPrimary($value)
 * @method static Builder<static>|Address whereLatitude($value)
 * @method static Builder<static>|Address whereLocality($value)
 * @method static Builder<static>|Address whereLongitude($value)
 * @method static Builder<static>|Address whereModelId($value)
 * @method static Builder<static>|Address whereModelType($value)
 * @method static Builder<static>|Address whereName($value)
 * @method static Builder<static>|Address wherePlaceId($value)
 * @method static Builder<static>|Address wherePostalCode($value)
 * @method static Builder<static>|Address whereRoute($value)
 * @method static Builder<static>|Address whereStreetNumber($value)
 * @method static Builder<static>|Address whereType($value)
 * @method static Builder<static>|Address whereUpdatedAt($value)
 * @method static Builder<static>|Address whereUpdatedBy($value)
 * @property ProfileContract|null $deleter
 * @method static AddressFactory factory($count = null, $state = [])
 * @property string|null $phone
 * @method static Builder<static>|Address wherePhone($value)
 * @mixin \Eloquent
 */
	class Address extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @property \Modules\Xot\Contracts\ProfileContract|null $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null $updater
 * @method static \Modules\Geo\Database\Factories\CountyFactory factory($count = null, $state = [])
 * @method static Builder<static>|County                        newModelQuery()
 * @method static Builder<static>|County                        newQuery()
 * @method static Builder<static>|County                        query()
 *                                                                                                  >>>>>>> 65bf1208 (.)
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @mixin \Eloquent
 */
	class County extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * Modules\Geo\Models\GeoNamesCap.
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|GeoNamesCap newModelQuery()
 * @method static Builder<static>|GeoNamesCap newQuery()
 * @method static Builder<static>|GeoNamesCap query()
 * @property ProfileContract|null $deleter
 * @method static GeoNamesCapFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class GeoNamesCap extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * Class Location.
 *
 * @property int                  $id
 * @property string|null          $model_type
 * @property string|null          $model_id
 * @property string|null          $name
 * @property float|null           $lat
 * @property float|null           $lng
 * @property string|null          $street
 * @property string|null          $city
 * @property string|null          $state
 * @property string|null          $zip
 * @property string|null          $formatted_address
 * @property string|null          $description
 * @property bool|null            $processed
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property string|null          $deleted_at
 * @property string|null          $deleted_by
 * @property ProfileContract|null $creator
 * @property array                $location
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Location newModelQuery()
 * @method static Builder<static>|Location newQuery()
 * @method static Builder<static>|Location query()
 * @method static Builder<static>|Location whereCity($value)
 * @method static Builder<static>|Location whereCreatedAt($value)
 * @method static Builder<static>|Location whereCreatedBy($value)
 * @method static Builder<static>|Location whereDeletedAt($value)
 * @method static Builder<static>|Location whereDeletedBy($value)
 * @method static Builder<static>|Location whereDescription($value)
 * @method static Builder<static>|Location whereFormattedAddress($value)
 * @method static Builder<static>|Location whereId($value)
 * @method static Builder<static>|Location whereLat($value)
 * @method static Builder<static>|Location whereLng($value)
 * @method static Builder<static>|Location whereModelId($value)
 * @method static Builder<static>|Location whereModelType($value)
 * @method static Builder<static>|Location whereName($value)
 * @method static Builder<static>|Location whereProcessed($value)
 * @method static Builder<static>|Location whereState($value)
 * @method static Builder<static>|Location whereStreet($value)
 * @method static Builder<static>|Location whereUpdatedAt($value)
 * @method static Builder<static>|Location whereUpdatedBy($value)
 * @method static Builder<static>|Location whereZip($value)
 * @method static Builder<static>|Location withinDistance(float $latitude, float $longitude, float $distanceInKm)
 * @property ProfileContract|null $deleter
 * @method static LocationFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Location extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @property Address|null         $address
 * @property ProfileContract|null $creator
 * @property string               $formatted_address
 * @property float|null           $latitude
 * @property float|null           $longitude
 * @property Model|\Eloquent      $linked
 * @property PlaceType|null       $placeType
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Place newModelQuery()
 * @method static Builder<static>|Place newQuery()
 * @method static Builder<static>|Place query()
 * @property int                  $id
 * @property string|null          $model_type
 * @property int|null             $model_id
 * @property string|null          $premise
 * @property string|null          $premise_short
 * @property string|null          $locality
 * @property string|null          $locality_short
 * @property string|null          $postal_town
 * @property string|null          $postal_town_short
 * @property string|null          $administrative_area_level_3
 * @property string|null          $administrative_area_level_3_short
 * @property string|null          $administrative_area_level_2
 * @property string|null          $administrative_area_level_2_short
 * @property string|null          $administrative_area_level_1
 * @property string|null          $administrative_area_level_1_short
 * @property string|null          $country
 * @property string|null          $country_short
 * @property string|null          $street_number
 * @property string|null          $street_number_short
 * @property string|null          $route
 * @property string|null          $route_short
 * @property string|null          $postal_code
 * @property string|null          $postal_code_short
 * @property string|null          $googleplace_url
 * @property string|null          $googleplace_url_short
 * @property string|null          $point_of_interest
 * @property string|null          $point_of_interest_short
 * @property string|null          $political
 * @property string|null          $political_short
 * @property string|null          $campground
 * @property string|null          $campground_short
 * @property string|null          $nearest_street
 * @property string|null          $created_by
 * @property string|null          $updated_by
 * @property string|null          $deleted_by
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $post_type
 * @property ProfileContract|null $deleter
 * @method static PlaceFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Place whereAddress($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel1($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel1Short($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel2($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel2Short($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel3($value)
 * @method static Builder<static>|Place whereAdministrativeAreaLevel3Short($value)
 * @method static Builder<static>|Place whereCampground($value)
 * @method static Builder<static>|Place whereCampgroundShort($value)
 * @method static Builder<static>|Place whereCountry($value)
 * @method static Builder<static>|Place whereCountryShort($value)
 * @method static Builder<static>|Place whereCreatedAt($value)
 * @method static Builder<static>|Place whereCreatedBy($value)
 * @method static Builder<static>|Place whereDeletedBy($value)
 * @method static Builder<static>|Place whereFormattedAddress($value)
 * @method static Builder<static>|Place whereGoogleplaceUrl($value)
 * @method static Builder<static>|Place whereGoogleplaceUrlShort($value)
 * @method static Builder<static>|Place whereId($value)
 * @method static Builder<static>|Place whereLatitude($value)
 * @method static Builder<static>|Place whereLocality($value)
 * @method static Builder<static>|Place whereLocalityShort($value)
 * @method static Builder<static>|Place whereLongitude($value)
 * @method static Builder<static>|Place whereModelId($value)
 * @method static Builder<static>|Place whereModelType($value)
 * @method static Builder<static>|Place whereNearestStreet($value)
 * @method static Builder<static>|Place wherePointOfInterest($value)
 * @method static Builder<static>|Place wherePointOfInterestShort($value)
 * @method static Builder<static>|Place wherePolitical($value)
 * @method static Builder<static>|Place wherePoliticalShort($value)
 * @method static Builder<static>|Place wherePostType($value)
 * @method static Builder<static>|Place wherePostalCode($value)
 * @method static Builder<static>|Place wherePostalCodeShort($value)
 * @method static Builder<static>|Place wherePostalTown($value)
 * @method static Builder<static>|Place wherePostalTownShort($value)
 * @method static Builder<static>|Place wherePremise($value)
 * @method static Builder<static>|Place wherePremiseShort($value)
 * @method static Builder<static>|Place whereRoute($value)
 * @method static Builder<static>|Place whereRouteShort($value)
 * @method static Builder<static>|Place whereStreetNumber($value)
 * @method static Builder<static>|Place whereStreetNumberShort($value)
 * @method static Builder<static>|Place whereUpdatedAt($value)
 * @method static Builder<static>|Place whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Place extends \Eloquent implements \Modules\Geo\Contracts\HasGeolocation {}
}

namespace Modules\Geo\Models{
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|PlaceType newModelQuery()
 * @method static Builder<static>|PlaceType newQuery()
 * @method static Builder<static>|PlaceType query()
 * @property ProfileContract|null $deleter
 * @method static PlaceTypeFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class PlaceType extends \Eloquent {}
}

namespace Modules\Geo\Models{
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|State newModelQuery()
 * @method static Builder<static>|State newQuery()
 * @method static Builder<static>|State query()
 * @property ProfileContract|null $deleter
 * @method static StateFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class State extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * @property string $id
 * @property Carbon|null $completed_at
 * @property string $file_disk
 * @property string|null $file_name
 * @property string $exporter
 * @property int $processed_rows
 * @property int $total_rows
 * @property int $successful_rows
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $user_type
 * @property-read Model|Eloquent|null $user
 * @method static Builder<static>|Export newModelQuery()
 * @method static Builder<static>|Export newQuery()
 * @method static Builder<static>|Export query()
 * @method static Builder<static>|Export whereCompletedAt($value)
 * @method static Builder<static>|Export whereCreatedAt($value)
 * @method static Builder<static>|Export whereCreatedBy($value)
 * @method static Builder<static>|Export whereDeletedAt($value)
 * @method static Builder<static>|Export whereDeletedBy($value)
 * @method static Builder<static>|Export whereExporter($value)
 * @method static Builder<static>|Export whereFileDisk($value)
 * @method static Builder<static>|Export whereFileName($value)
 * @method static Builder<static>|Export whereId($value)
 * @method static Builder<static>|Export whereProcessedRows($value)
 * @method static Builder<static>|Export whereSuccessfulRows($value)
 * @method static Builder<static>|Export whereTotalRows($value)
 * @method static Builder<static>|Export whereUpdatedAt($value)
 * @method static Builder<static>|Export whereUpdatedBy($value)
 * @method static Builder<static>|Export whereUserId($value)
 * @method static Builder<static>|Export whereUserType($value)
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin IdeHelperExport
 * @mixin Eloquent
 */
	class Export extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * @property string $id
 * @property array<array-key, mixed> $data
 * @property int $import_id
 * @property string|null $validation_error
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static FailedImportRowFactory factory($count = null, $state = [])
 * @method static Builder<static>|FailedImportRow newModelQuery()
 * @method static Builder<static>|FailedImportRow newQuery()
 * @method static Builder<static>|FailedImportRow query()
 * @method static Builder<static>|FailedImportRow whereCreatedAt($value)
 * @method static Builder<static>|FailedImportRow whereCreatedBy($value)
 * @method static Builder<static>|FailedImportRow whereData($value)
 * @method static Builder<static>|FailedImportRow whereId($value)
 * @method static Builder<static>|FailedImportRow whereImportId($value)
 * @method static Builder<static>|FailedImportRow whereUpdatedAt($value)
 * @method static Builder<static>|FailedImportRow whereUpdatedBy($value)
 * @method static Builder<static>|FailedImportRow whereValidationError($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class FailedImportRow extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\FailedJob.
 *
 * @property string $id
 * @property string $uuid
 * @property string $connection
 * @property string $queue
 * @property array<array-key, mixed> $payload
 * @property string $exception
 * @property string $failed_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static FailedJobFactory factory($count = null, $state = [])
 * @method static Builder<static>|FailedJob newModelQuery()
 * @method static Builder<static>|FailedJob newQuery()
 * @method static Builder<static>|FailedJob query()
 * @method static Builder<static>|FailedJob whereConnection($value)
 * @method static Builder<static>|FailedJob whereException($value)
 * @method static Builder<static>|FailedJob whereFailedAt($value)
 * @method static Builder<static>|FailedJob whereId($value)
 * @method static Builder<static>|FailedJob wherePayload($value)
 * @method static Builder<static>|FailedJob whereQueue($value)
 * @method static Builder<static>|FailedJob whereUuid($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class FailedJob extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Frequency.
 *
 * @property string $id
 * @property int $task_id
 * @property string $label
 * @property string $interval
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read Collection<int, Parameter> $parameters
 * @property-read int|null $parameters_count
 * @property-read Task|null $task
 * @property-read ProfileContract|null $updater
 * @method static FrequencyFactory factory($count = null, $state = [])
 * @method static Builder<static>|Frequency newModelQuery()
 * @method static Builder<static>|Frequency newQuery()
 * @method static Builder<static>|Frequency query()
 * @method static Builder<static>|Frequency whereCreatedAt($value)
 * @method static Builder<static>|Frequency whereCreatedBy($value)
 * @method static Builder<static>|Frequency whereId($value)
 * @method static Builder<static>|Frequency whereInterval($value)
 * @method static Builder<static>|Frequency whereLabel($value)
 * @method static Builder<static>|Frequency whereTaskId($value)
 * @method static Builder<static>|Frequency whereUpdatedAt($value)
 * @method static Builder<static>|Frequency whereUpdatedBy($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Frequency extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * @property string $id
 * @property Carbon|null $completed_at
 * @property string $file_name
 * @property string $file_path
 * @property string $importer
 * @property int $processed_rows
 * @property int $total_rows
 * @property int $successful_rows
 * @property string|null $user_type
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static ImportFactory factory($count = null, $state = [])
 * @method static Builder<static>|Import newModelQuery()
 * @method static Builder<static>|Import newQuery()
 * @method static Builder<static>|Import query()
 * @method static Builder<static>|Import whereCompletedAt($value)
 * @method static Builder<static>|Import whereCreatedAt($value)
 * @method static Builder<static>|Import whereCreatedBy($value)
 * @method static Builder<static>|Import whereDeletedAt($value)
 * @method static Builder<static>|Import whereDeletedBy($value)
 * @method static Builder<static>|Import whereFileName($value)
 * @method static Builder<static>|Import whereFilePath($value)
 * @method static Builder<static>|Import whereId($value)
 * @method static Builder<static>|Import whereImporter($value)
 * @method static Builder<static>|Import whereProcessedRows($value)
 * @method static Builder<static>|Import whereSuccessfulRows($value)
 * @method static Builder<static>|Import whereTotalRows($value)
 * @method static Builder<static>|Import whereUpdatedAt($value)
 * @method static Builder<static>|Import whereUpdatedBy($value)
 * @method static Builder<static>|Import whereUserId($value)
 * @method static Builder<static>|Import whereUserType($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Import extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Job.
 *
 * @property int $id
 * @property string $queue
 * @property array<array-key, mixed> $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property Carbon $created_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read string|null $display_name
 * @property-read string $status
 * @property-read ProfileContract|null $updater
 * @method static JobFactory factory($count = null, $state = [])
 * @method static Builder<static>|Job newModelQuery()
 * @method static Builder<static>|Job newQuery()
 * @method static Builder<static>|Job query()
 * @method static Builder<static>|Job whereAttempts($value)
 * @method static Builder<static>|Job whereAvailableAt($value)
 * @method static Builder<static>|Job whereCreatedAt($value)
 * @method static Builder<static>|Job whereCreatedBy($value)
 * @method static Builder<static>|Job whereId($value)
 * @method static Builder<static>|Job wherePayload($value)
 * @method static Builder<static>|Job whereQueue($value)
 * @method static Builder<static>|Job whereReservedAt($value)
 * @method static Builder<static>|Job whereUpdatedAt($value)
 * @method static Builder<static>|Job whereUpdatedBy($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Job extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\JobBatch.
 *
 * @property string $id
 * @property string $name
 * @property int $total_jobs
 * @property int $pending_jobs
 * @property int $failed_jobs
 * @property string $failed_job_ids
 * @property Collection<array-key, mixed>|null $options
 * @property Carbon|null $cancelled_at
 * @property Carbon $created_at
 * @property Carbon|null $finished_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static JobBatchFactory factory($count = null, $state = [])
 * @method static Builder<static>|JobBatch newModelQuery()
 * @method static Builder<static>|JobBatch newQuery()
 * @method static Builder<static>|JobBatch query()
 * @method static Builder<static>|JobBatch whereCancelledAt($value)
 * @method static Builder<static>|JobBatch whereCreatedAt($value)
 * @method static Builder<static>|JobBatch whereFailedJobIds($value)
 * @method static Builder<static>|JobBatch whereFailedJobs($value)
 * @method static Builder<static>|JobBatch whereFinishedAt($value)
 * @method static Builder<static>|JobBatch whereId($value)
 * @method static Builder<static>|JobBatch whereName($value)
 * @method static Builder<static>|JobBatch whereOptions($value)
 * @method static Builder<static>|JobBatch wherePendingJobs($value)
 * @method static Builder<static>|JobBatch whereTotalJobs($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class JobBatch extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * @property string $id
 * @property string $job_id
 * @property string|null $name
 * @property string|null $queue
 * @property Carbon|null $started_at
 * @property Carbon|null $finished_at
 * @property bool $failed
 * @property int $attempt
 * @property int|null $progress
 * @property string|null $exception_message
 * @property-read ProfileContract|null $creator
 * @property-read string $status
 * @property-read ProfileContract|null $updater
 * @method static JobManagerFactory factory($count = null, $state = [])
 * @method static Builder<static>|JobManager newModelQuery()
 * @method static Builder<static>|JobManager newQuery()
 * @method static Builder<static>|JobManager query()
 * @method static Builder<static>|JobManager whereAttempt($value)
 * @method static Builder<static>|JobManager whereExceptionMessage($value)
 * @method static Builder<static>|JobManager whereFailed($value)
 * @method static Builder<static>|JobManager whereFinishedAt($value)
 * @method static Builder<static>|JobManager whereId($value)
 * @method static Builder<static>|JobManager whereJobId($value)
 * @method static Builder<static>|JobManager whereName($value)
 * @method static Builder<static>|JobManager whereProgress($value)
 * @method static Builder<static>|JobManager whereQueue($value)
 * @method static Builder<static>|JobManager whereStartedAt($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class JobManager extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\JobsWaiting.
 *
 * @property int $id
 * @property string $queue
 * @property array<array-key, mixed> $payload
 * @property int $attempts
 * @property int|null $reserved_at
 * @property int $available_at
 * @property Carbon $created_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read string|null $display_name
 * @property-read string $status
 * @property-read ProfileContract|null $updater
 * @method static JobsWaitingFactory factory($count = null, $state = [])
 * @method static Builder<static>|JobsWaiting newModelQuery()
 * @method static Builder<static>|JobsWaiting newQuery()
 * @method static Builder<static>|JobsWaiting query()
 * @method static Builder<static>|JobsWaiting whereAttempts($value)
 * @method static Builder<static>|JobsWaiting whereAvailableAt($value)
 * @method static Builder<static>|JobsWaiting whereCreatedAt($value)
 * @method static Builder<static>|JobsWaiting whereCreatedBy($value)
 * @method static Builder<static>|JobsWaiting whereId($value)
 * @method static Builder<static>|JobsWaiting wherePayload($value)
 * @method static Builder<static>|JobsWaiting whereQueue($value)
 * @method static Builder<static>|JobsWaiting whereReservedAt($value)
 * @method static Builder<static>|JobsWaiting whereUpdatedAt($value)
 * @method static Builder<static>|JobsWaiting whereUpdatedBy($value)
 * @mixin IdeHelperJobsWaiting
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class JobsWaiting extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Parameter.
 *
 * @property string $id
 * @property int $frequency_id
 * @property string $name
 * @property string $value
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read Frequency|null $task
 * @property-read ProfileContract|null $updater
 * @method static ParameterFactory factory($count = null, $state = [])
 * @method static Builder<static>|Parameter newModelQuery()
 * @method static Builder<static>|Parameter newQuery()
 * @method static Builder<static>|Parameter query()
 * @method static Builder<static>|Parameter whereCreatedAt($value)
 * @method static Builder<static>|Parameter whereCreatedBy($value)
 * @method static Builder<static>|Parameter whereFrequencyId($value)
 * @method static Builder<static>|Parameter whereId($value)
 * @method static Builder<static>|Parameter whereName($value)
 * @method static Builder<static>|Parameter whereUpdatedAt($value)
 * @method static Builder<static>|Parameter whereUpdatedBy($value)
 * @method static Builder<static>|Parameter whereValue($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Parameter extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Result.
 *
 * @property string $id
 * @property int $task_id
 * @property Carbon $ran_at
 * @property string $duration
 * @property string $result
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read Task|null $task
 * @property-read ProfileContract|null $updater
 * @method static Factory<static> factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereRanAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Result whereUpdatedBy($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Result extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Schedule.
 *
 * @property string $id
 * @property string $command
 * @property string|null $command_custom
 * @property array<array-key, array{name?: string, value?: bool|float|int|string|null, required?: bool, type?: string}>|null $params
 * @property string $expression
 * @property array<array-key, bool|float|int|string|null>|null $environments
 * @property array<array-key, array{name?: string, value?: bool|float|int|string|null}|bool|float|int|string|null>|null $options
 * @property array<array-key, array{name?: string, value?: bool|float|int|string|null, required?: bool, type?: string}>|null $options_with_value
 * @property string|null $log_filename
 * @property int $even_in_maintenance_mode
 * @property int $without_overlapping
 * @property int $on_one_server
 * @property string|null $webhook_before
 * @property string|null $webhook_after
 * @property string|null $email_output
 * @property int $sendmail_error
 * @property int $log_success
 * @property int $log_error
 * @property Status $status
 * @property int $run_in_background
 * @property int $sendmail_success
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property ProfileContract|null $creator
 * @property \Illuminate\Database\Eloquent\Collection<int, ScheduleHistory> $histories
 * @property int|null $histories_count
 * @property ProfileContract|null $updater
 * @method static Builder<static>|Schedule active()
 * @method static ScheduleFactory factory($count = null, $state = [])
 * @method static Builder<static>|Schedule inactive()
 * @method static Builder<static>|Schedule newModelQuery()
 * @method static Builder<static>|Schedule newQuery()
 * @method static Builder<static>|Schedule onlyTrashed()
 * @method static Builder<static>|Schedule query()
 * @method static Builder<static>|Schedule whereCommand($value)
 * @method static Builder<static>|Schedule whereCommandCustom($value)
 * @method static Builder<static>|Schedule whereCreatedAt($value)
 * @method static Builder<static>|Schedule whereCreatedBy($value)
 * @method static Builder<static>|Schedule whereDeletedAt($value)
 * @method static Builder<static>|Schedule whereDeletedBy($value)
 * @method static Builder<static>|Schedule whereEmailOutput($value)
 * @method static Builder<static>|Schedule whereEnvironments($value)
 * @method static Builder<static>|Schedule whereEvenInMaintenanceMode($value)
 * @method static Builder<static>|Schedule whereExpression($value)
 * @method static Builder<static>|Schedule whereId($value)
 * @method static Builder<static>|Schedule whereLogError($value)
 * @method static Builder<static>|Schedule whereLogFilename($value)
 * @method static Builder<static>|Schedule whereLogSuccess($value)
 * @method static Builder<static>|Schedule whereOnOneServer($value)
 * @method static Builder<static>|Schedule whereOptions($value)
 * @method static Builder<static>|Schedule whereOptionsWithValue($value)
 * @method static Builder<static>|Schedule whereParams($value)
 * @method static Builder<static>|Schedule whereRunInBackground($value)
 * @method static Builder<static>|Schedule whereSendmailError($value)
 * @method static Builder<static>|Schedule whereSendmailSuccess($value)
 * @method static Builder<static>|Schedule whereStatus($value)
 * @method static Builder<static>|Schedule whereUpdatedAt($value)
 * @method static Builder<static>|Schedule whereUpdatedBy($value)
 * @method static Builder<static>|Schedule whereWebhookAfter($value)
 * @method static Builder<static>|Schedule whereWebhookBefore($value)
 * @method static Builder<static>|Schedule whereWithoutOverlapping($value)
 * @method static Builder<static>|Schedule withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Schedule withoutTrashed()
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Schedule extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\ScheduleHistory.
 *
 * @property string $id
 * @property Schedule|null $command
 * @property array<array-key, mixed>|null $params
 * @property string $output
 * @property array<array-key, mixed>|null $options
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $schedule_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static ScheduleHistoryFactory factory($count = null, $state = [])
 * @method static Builder<static>|ScheduleHistory newModelQuery()
 * @method static Builder<static>|ScheduleHistory newQuery()
 * @method static Builder<static>|ScheduleHistory query()
 * @method static Builder<static>|ScheduleHistory whereCommand($value)
 * @method static Builder<static>|ScheduleHistory whereCreatedAt($value)
 * @method static Builder<static>|ScheduleHistory whereCreatedBy($value)
 * @method static Builder<static>|ScheduleHistory whereDeletedAt($value)
 * @method static Builder<static>|ScheduleHistory whereDeletedBy($value)
 * @method static Builder<static>|ScheduleHistory whereId($value)
 * @method static Builder<static>|ScheduleHistory whereOptions($value)
 * @method static Builder<static>|ScheduleHistory whereOutput($value)
 * @method static Builder<static>|ScheduleHistory whereParams($value)
 * @method static Builder<static>|ScheduleHistory whereScheduleId($value)
 * @method static Builder<static>|ScheduleHistory whereUpdatedAt($value)
 * @method static Builder<static>|ScheduleHistory whereUpdatedBy($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class ScheduleHistory extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Modules\Job\Models\Task.
 *
 * @property string $id
 * @property string $description
 * @property string $command
 * @property string|null $parameters
 * @property string|null $expression
 * @property string $timezone
 * @property int $is_active
 * @property int $dont_overlap
 * @property int $run_in_maintenance
 * @property string|null $notification_email_address
 * @property string|null $notification_phone_number
 * @property string $notification_slack_webhook
 * @property int $auto_cleanup_num
 * @property string|null $auto_cleanup_type
 * @property int $run_on_one_server
 * @property int $run_in_background
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProfileContract|null $creator
 * @property-read Collection<int, Frequency> $frequencies
 * @property-read int|null $frequencies_count
 * @property-read bool $activated
 * @property-read float $average_runtime
 * @property-read Result|null $last_result
 * @property-read string $upcoming
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Result> $results
 * @property-read int|null $results_count
 * @property-read ProfileContract|null $updater
 * @method static Builder<static>|Task newModelQuery()
 * @method static Builder<static>|Task newQuery()
 * @method static Builder<static>|Task query()
 * @method static Builder<static>|Task sortableBy(array $sortableColumns, array $defaultSort = [])
 * @method static Builder<static>|Task whereAutoCleanupNum($value)
 * @method static Builder<static>|Task whereAutoCleanupType($value)
 * @method static Builder<static>|Task whereCommand($value)
 * @method static Builder<static>|Task whereCreatedAt($value)
 * @method static Builder<static>|Task whereCreatedBy($value)
 * @method static Builder<static>|Task whereDescription($value)
 * @method static Builder<static>|Task whereDontOverlap($value)
 * @method static Builder<static>|Task whereExpression($value)
 * @method static Builder<static>|Task whereId($value)
 * @method static Builder<static>|Task whereIsActive($value)
 * @method static Builder<static>|Task whereNotificationEmailAddress($value)
 * @method static Builder<static>|Task whereNotificationPhoneNumber($value)
 * @method static Builder<static>|Task whereNotificationSlackWebhook($value)
 * @method static Builder<static>|Task whereParameters($value)
 * @method static Builder<static>|Task whereRunInBackground($value)
 * @method static Builder<static>|Task whereRunInMaintenance($value)
 * @method static Builder<static>|Task whereRunOnOneServer($value)
 * @method static Builder<static>|Task whereTimezone($value)
 * @method static Builder<static>|Task whereUpdatedAt($value)
 * @method static Builder<static>|Task whereUpdatedBy($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read ProfileContract|null $deleter
 * @method static TaskFactory factory($count = null, $state = [])
 * @method static Builder<static>|Task whereDeletedAt($value)
 * @method static Builder<static>|Task whereDeletedBy($value)
 * @mixin \Eloquent
 */
	class Task extends \Eloquent {}
}

namespace Modules\Job\Models{
/**
 * Class TaskComment.
 *
 * @property ProfileContract|null $creator
 * @property Task|null $task
 * @property ProfileContract|null $updater
 * @property User|null $user
 * @method static Builder<static>|TaskComment newModelQuery()
 * @method static Builder<static>|TaskComment newQuery()
 * @method static Builder<static>|TaskComment onlyTrashed()
 * @method static Builder<static>|TaskComment query()
 * @method static Builder<static>|TaskComment withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|TaskComment withoutTrashed()
 * @property-read ProfileContract|null $deleter
 * @method static TaskCommentFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class TaskComment extends \Eloquent {}
}

namespace Modules\Lang\Models{
/**
 * Modules\Lang\Models\Post.
 *
 * @property string                       $id
 * @property int|null                     $user_id
 * @property string|null                  $post_type
 * @property int|null                     $post_id
 * @property string|null                  $lang
 * @property string|null                  $title
 * @property string|null                  $subtitle
 * @property string|null                  $guid
 * @property string|null                  $txt
 * @property string|null                  $image_src
 * @property string|null                  $image_alt
 * @property string|null                  $image_title
 * @property string|null                  $meta_description
 * @property string|null                  $meta_keywords
 * @property int|null                     $author_id
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property int|null                     $category_id
 * @property string|null                  $image
 * @property string|null                  $content
 * @property int|null                     $published
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property string|null                  $url
 * @property array<array-key, mixed>|null $url_lang
 * @property array<array-key, mixed>|null $image_resize_src
 * @property string|null                  $linked_count
 * @property string|null                  $related_count
 * @property string|null                  $relatedrev_count
 * @property string|null                  $linkable_type
 * @property int|null                     $views_count
 * @property ProfileContract|null         $creator
 * @property Model|\Eloquent|null         $linkable
 * @property ProfileContract|null         $updater
 * @method static Builder<static>|Post newModelQuery()
 * @method static Builder<static>|Post newQuery()
 * @method static Builder<static>|Post query()
 * @method static Builder<static>|Post whereAuthorId($value)
 * @method static Builder<static>|Post whereCategoryId($value)
 * @method static Builder<static>|Post whereContent($value)
 * @method static Builder<static>|Post whereCreatedAt($value)
 * @method static Builder<static>|Post whereCreatedBy($value)
 * @method static Builder<static>|Post whereGuid($value)
 * @method static Builder<static>|Post whereId($value)
 * @method static Builder<static>|Post whereImage($value)
 * @method static Builder<static>|Post whereImageAlt($value)
 * @method static Builder<static>|Post whereImageResizeSrc($value)
 * @method static Builder<static>|Post whereImageSrc($value)
 * @method static Builder<static>|Post whereImageTitle($value)
 * @method static Builder<static>|Post whereLang($value)
 * @method static Builder<static>|Post whereLinkableType($value)
 * @method static Builder<static>|Post whereLinkedCount($value)
 * @method static Builder<static>|Post whereMetaDescription($value)
 * @method static Builder<static>|Post whereMetaKeywords($value)
 * @method static Builder<static>|Post wherePostId($value)
 * @method static Builder<static>|Post wherePostType($value)
 * @method static Builder<static>|Post wherePublished($value)
 * @method static Builder<static>|Post whereRelatedCount($value)
 * @method static Builder<static>|Post whereRelatedrevCount($value)
 * @method static Builder<static>|Post whereSubtitle($value)
 * @method static Builder<static>|Post whereTitle($value)
 * @method static Builder<static>|Post whereTxt($value)
 * @method static Builder<static>|Post whereUpdatedAt($value)
 * @method static Builder<static>|Post whereUpdatedBy($value)
 * @method static Builder<static>|Post whereUrl($value)
 * @method static Builder<static>|Post whereUrlLang($value)
 * @method static Builder<static>|Post whereUserId($value)
 * @method static Builder<static>|Post whereViewsCount($value)
 * @property ProfileContract|null $deleter
 * @method static PostFactory factory($count = null, $state = [])
 * @property string|null $excerpt
 * @property string|null $slug
 * @property string|null $status
 * @property Carbon|null $published_at
 * @property string|null $locale
 * @property string|null $category
 * @property string|null $meta_title
 * @method static Builder<static>|Post whereCategory($value)
 * @method static Builder<static>|Post whereExcerpt($value)
 * @method static Builder<static>|Post whereLocale($value)
 * @method static Builder<static>|Post whereMetaTitle($value)
 * @method static Builder<static>|Post wherePublishedAt($value)
 * @method static Builder<static>|Post whereSlug($value)
 * @method static Builder<static>|Post whereStatus($value)
 * @mixin Eloquent
 */
	class Post extends \Eloquent {}
}

namespace Modules\Lang\Models{
/**
 * Modules\Lang\Models\Translation.
 *
 * @property string               $id
 * @property string|null          $lang
 * @property string|null          $key
 * @property string|null          $value
 * @property string|null          $created_by
 * @property string|null          $updated_by
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string               $namespace
 * @property string               $group
 * @property string|null          $item
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static TranslationFactory                  factory($count = null, $state = [])
 * @method static EloquentBuilder<static>|Translation newModelQuery()
 * @method static EloquentBuilder<static>|Translation newQuery()
 * @method static EloquentBuilder<static>|Translation ofTranslatedGroup(string $group)
 * @method static EloquentBuilder<static>|Translation orderByGroupKeys(bool $ordered)
 * @method static EloquentBuilder<static>|Translation query()
 * @method static EloquentBuilder<static>|Translation selectDistinctGroup()
 * @method static EloquentBuilder<static>|Translation whereCreatedAt($value)
 * @method static EloquentBuilder<static>|Translation whereCreatedBy($value)
 * @method static EloquentBuilder<static>|Translation whereGroup($value)
 * @method static EloquentBuilder<static>|Translation whereId($value)
 * @method static EloquentBuilder<static>|Translation whereItem($value)
 * @method static EloquentBuilder<static>|Translation whereKey($value)
 * @method static EloquentBuilder<static>|Translation whereLang($value)
 * @method static EloquentBuilder<static>|Translation whereNamespace($value)
 * @method static EloquentBuilder<static>|Translation whereUpdatedAt($value)
 * @method static EloquentBuilder<static>|Translation whereUpdatedBy($value)
 * @method static EloquentBuilder<static>|Translation whereValue($value)
 * @property ProfileContract|null $deleter
 * @property string|null $locale
 * @property int|null $user_id
 * @method static EloquentBuilder<static>|Translation whereLocale($value)
 * @method static EloquentBuilder<static>|Translation whereUserId($value)
 * @mixin \Eloquent
 */
	class Translation extends \Eloquent {}
}

namespace Modules\Lang\Models{
/**
 * @property string|null                  $key
 * @property string|null                  $path
 * @property string|null                  $id
 * @property string|null                  $name
 * @property array<array-key, mixed>|null $content
 * @property ProfileContract|null         $creator
 * @property ProfileContract|null         $updater
 * @method static TranslationFileFactory          factory($count = null, $state = [])
 * @method static Builder<static>|TranslationFile newModelQuery()
 * @method static Builder<static>|TranslationFile newQuery()
 * @method static Builder<static>|TranslationFile query()
 * @method static Builder<static>|TranslationFile whereContent($value)
 * @method static Builder<static>|TranslationFile whereId($value)
 * @method static Builder<static>|TranslationFile whereKey($value)
 * @method static Builder<static>|TranslationFile whereName($value)
 * @method static Builder<static>|TranslationFile wherePath($value)
 * @property ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class TranslationFile extends \Eloquent {}
}

namespace Modules\Media\Models{
/**
 * Modules\Media\Models\Media.
 *
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array|null $manipulations
 * @property array|null $custom_properties
 * @property array|null $generated_conversions
 * @property array|null $responsive_images
 * @property int|null $order_column
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property string $directory
 * @property string|null $path
 * @property int|null $width
 * @property int|null $height
 * @property string|null $type
 * @property string|null $ext
 * @property string|null $alt
 * @property string|null $title
 * @property string|null $description
 * @property string|null $caption
 * @property string|null $exif
 * @property string|null $curations
 * @property UserContract|null $creator
 * @property Model|Eloquent $model
 * @property TemporaryUpload|null $temporaryUpload
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static Builder|Media newModelQuery()
 * @method static Builder|Media newQuery()
 * @method static Builder|Media ordered()
 * @method static Builder|Media query()
 * @method static Builder|Media whereAlt($value)
 * @method static Builder|Media whereCaption($value)
 * @method static Builder|Media whereCollectionName($value)
 * @method static Builder|Media whereConversionsDisk($value)
 * @method static Builder|Media whereCreatedAt($value)
 * @method static Builder|Media whereCreatedBy($value)
 * @method static Builder|Media whereCurations($value)
 * @method static Builder|Media whereCustomProperties($value)
 * @method static Builder|Media whereDescription($value)
 * @method static Builder|Media whereDirectory($value)
 * @method static Builder|Media whereDisk($value)
 * @method static Builder|Media whereExif($value)
 * @method static Builder|Media whereExt($value)
 * @method static Builder|Media whereFileName($value)
 * @method static Builder|Media whereGeneratedConversions($value)
 * @method static Builder|Media whereHeight($value)
 * @method static Builder|Media whereId($value)
 * @method static Builder|Media whereManipulations($value)
 * @method static Builder|Media whereMimeType($value)
 * @method static Builder|Media whereModelId($value)
 * @method static Builder|Media whereModelType($value)
 * @method static Builder|Media whereName($value)
 * @method static Builder|Media whereOrderColumn($value)
 * @method static Builder|Media wherePath($value)
 * @method static Builder|Media whereResponsiveImages($value)
 * @method static Builder|Media whereSize($value)
 * @method static Builder|Media whereTitle($value)
 * @method static Builder|Media whereType($value)
 * @method static Builder|Media whereUpdatedAt($value)
 * @method static Builder|Media whereUpdatedBy($value)
 * @method static Builder|Media whereUserId($value)
 * @method static Builder|Media whereUuid($value)
 * @method static Builder|Media whereWidth($value)
 * @property mixed $extension
 * @property mixed $human_readable_size
 * @property mixed $original_url
 * @property mixed $preview_url
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static Builder|Media whereDeletedAt($value)
 * @method static Builder|Media whereDeletedBy($value)
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @property array $entry_conversions
 * @property EloquentCollection<int, MediaConvert> $mediaConverts
 * @property int|null $media_converts_count
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @property ProfileContract|null $updater
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @mixin IdeHelperMedia
 * @method static MediaFactory factory($count = null, $state = [])
 * @property-read ProfileContract|null $deleter
 * @mixin Eloquent
 */
	class Media extends \Eloquent {}
}

namespace Modules\Media\Models{
/**
 * @property int $id
 * @property int $media_id
 * @property string|null $codec_video
 * @property string|null $codec_audio
 * @property string|null $preset
 * @property string|null $bitrate
 * @property int|null $width
 * @property int|null $height
 * @property int|null $threads
 * @property int|null $speed
 * @property string|null $percentage
 * @property string|null $remaining
 * @property string|null $rate
 * @property string|null $execution_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $format
 * @property string|null $converted_file
 * @property string|null $disk
 * @property string|null $file
 * @property Media|null $media
 * @method static MediaConvertFactory factory($count = null, $state = [])
 * @method static Builder|MediaConvert newModelQuery()
 * @method static Builder|MediaConvert newQuery()
 * @method static Builder|MediaConvert query()
 * @method static Builder|MediaConvert whereBitrate($value)
 * @method static Builder|MediaConvert whereCodecAudio($value)
 * @method static Builder|MediaConvert whereCodecVideo($value)
 * @method static Builder|MediaConvert whereCreatedAt($value)
 * @method static Builder|MediaConvert whereCreatedBy($value)
 * @method static Builder|MediaConvert whereDeletedAt($value)
 * @method static Builder|MediaConvert whereDeletedBy($value)
 * @method static Builder|MediaConvert whereExecutionTime($value)
 * @method static Builder|MediaConvert whereFormat($value)
 * @method static Builder|MediaConvert whereHeight($value)
 * @method static Builder|MediaConvert whereId($value)
 * @method static Builder|MediaConvert whereMediaId($value)
 * @method static Builder|MediaConvert wherePercentage($value)
 * @method static Builder|MediaConvert wherePreset($value)
 * @method static Builder|MediaConvert whereRate($value)
 * @method static Builder|MediaConvert whereRemaining($value)
 * @method static Builder|MediaConvert whereSpeed($value)
 * @method static Builder|MediaConvert whereThreads($value)
 * @method static Builder|MediaConvert whereUpdatedAt($value)
 * @method static Builder|MediaConvert whereUpdatedBy($value)
 * @method static Builder|MediaConvert whereWidth($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @mixin IdeHelperMediaConvert
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class MediaConvert extends \Eloquent {}
}

namespace Modules\Media\Models{
/**
 * Modules\Media\Models\TemporaryUpload.
 *
 * @property int $id
 * @property string $session_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property MediaCollection<int, Media> $media
 * @property int|null $media_count
 * @method static Builder<static>|TemporaryUpload newModelQuery()
 * @method static Builder<static>|TemporaryUpload newQuery()
 * @method static Builder<static>|TemporaryUpload query()
 * @method static Builder<static>|TemporaryUpload whereCreatedAt($value)
 * @method static Builder<static>|TemporaryUpload whereId($value)
 * @method static Builder<static>|TemporaryUpload whereSessionId($value)
 * @method static Builder<static>|TemporaryUpload whereUpdatedAt($value)
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder<static>|TemporaryUpload whereCreatedBy($value)
 * @method static Builder<static>|TemporaryUpload whereDeletedAt($value)
 * @method static Builder<static>|TemporaryUpload whereDeletedBy($value)
 * @method static Builder<static>|TemporaryUpload whereUpdatedBy($value)
 * @mixin IdeHelperTemporaryUpload
 * @method static TemporaryUploadFactory factory($count = null, $state = [])
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @property string|null $user_id
 * @property string $file_name
 * @property int|null $file_size
 * @property string|null $mime_type
 * @property string $status
 * @method static Builder<static>|TemporaryUpload whereFileName($value)
 * @method static Builder<static>|TemporaryUpload whereFileSize($value)
 * @method static Builder<static>|TemporaryUpload whereMimeType($value)
 * @method static Builder<static>|TemporaryUpload whereStatus($value)
 * @method static Builder<static>|TemporaryUpload whereUserId($value)
 * @mixin \Eloquent
 */
	class TemporaryUpload extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace Modules\Meetup\Models{
/**
 * Modules\Meetup\Models\Event.
 * 
 * Schema.org Event implementation with structured data support.
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $in_language
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string|null $duration
 * @property string $location
 * @property int|null $location_id
 * @property string $status
 * @property EventStatus $event_status
 * @property EventAttendanceMode $event_attendance_mode
 * @property int $attendees_count
 * @property int $max_attendees
 * @property string|null $cover_image
 * @property string|null $slug
 * @property string|null $url
 * @property array<array-key, mixed>|null $offers
 * @property array<array-key, mixed>|null $meta_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property int|null $organizer_id
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $owner
 * @property-read User|null $organizer
 * @method static Builder<Event> newModelQuery()
 * @method static Builder<Event> newQuery()
 * @method static Builder<Event> query()
 * @method static Builder<Event> upcoming()
 * @method static Builder<Event> past()
 * @method static Builder<Event> bySlug(string $slug)
 * @method static Builder<Event> dateRange(Carbon $startDate, Carbon $endDate)
 * @see https://schema.org/Event
 * @property string|null $alternate_name
 * @property string|null $door_time
 * @property int $is_accessible_for_free
 * @property string|null $keywords
 * @property string|null $typical_age_range
 * @property string|null $audience
 * @property string|null $previous_start_date
 * @property string|null $registration_opens_at
 * @property string|null $registration_url
 * @property string|null $repeat_frequency
 * @property string|null $repeat_days
 * @property int|null $repeat_count
 * @property string|null $schedule_end_date
 * @property string|null $except_dates
 * @property string $schedule_timezone
 * @property int|null $super_event_id
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Activity\Models\Snapshot> $snapshots
 * @property-read int|null $snapshots_count
 * @property-read \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection<int, \Modules\Activity\Models\StoredEvent> $storedEvents
 * @property-read int|null $stored_events_count
 * @method static \Modules\Meetup\Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static Builder<static>|Event whereAlternateName($value)
 * @method static Builder<static>|Event whereAttendeesCount($value)
 * @method static Builder<static>|Event whereAudience($value)
 * @method static Builder<static>|Event whereCoverImage($value)
 * @method static Builder<static>|Event whereCreatedAt($value)
 * @method static Builder<static>|Event whereCreatedBy($value)
 * @method static Builder<static>|Event whereDescription($value)
 * @method static Builder<static>|Event whereDoorTime($value)
 * @method static Builder<static>|Event whereDuration($value)
 * @method static Builder<static>|Event whereEndDate($value)
 * @method static Builder<static>|Event whereEventAttendanceMode($value)
 * @method static Builder<static>|Event whereEventStatus($value)
 * @method static Builder<static>|Event whereExceptDates($value)
 * @method static Builder<static>|Event whereId($value)
 * @method static Builder<static>|Event whereInLanguage($value)
 * @method static Builder<static>|Event whereIsAccessibleForFree($value)
 * @method static Builder<static>|Event whereKeywords($value)
 * @method static Builder<static>|Event whereLocation($value)
 * @method static Builder<static>|Event whereLocationId($value)
 * @method static Builder<static>|Event whereMaxAttendees($value)
 * @method static Builder<static>|Event whereMetaData($value)
 * @method static Builder<static>|Event whereOffers($value)
 * @method static Builder<static>|Event wherePreviousStartDate($value)
 * @method static Builder<static>|Event whereRegistrationOpensAt($value)
 * @method static Builder<static>|Event whereRegistrationUrl($value)
 * @method static Builder<static>|Event whereRepeatCount($value)
 * @method static Builder<static>|Event whereRepeatDays($value)
 * @method static Builder<static>|Event whereRepeatFrequency($value)
 * @method static Builder<static>|Event whereScheduleEndDate($value)
 * @method static Builder<static>|Event whereScheduleTimezone($value)
 * @method static Builder<static>|Event whereSlug($value)
 * @method static Builder<static>|Event whereStartDate($value)
 * @method static Builder<static>|Event whereStatus($value)
 * @method static Builder<static>|Event whereSuperEventId($value)
 * @method static Builder<static>|Event whereTitle($value)
 * @method static Builder<static>|Event whereTypicalAgeRange($value)
 * @method static Builder<static>|Event whereUpdatedAt($value)
 * @method static Builder<static>|Event whereUpdatedBy($value)
 * @method static Builder<static>|Event whereUrl($value)
 * @method static Builder<static>|Event whereUserId($value)
 * @mixin \Eloquent
 */
	class Event extends \Eloquent {}
}

namespace Modules\Meetup\Models{
/**
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 * @method static \Modules\Meetup\Database\Factories\EventPerformerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventPerformer query()
 * @mixin \Eloquent
 */
	class EventPerformer extends \Eloquent {}
}

namespace Modules\Meetup\Models{
/**
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 * @method static \Modules\Meetup\Database\Factories\EventSponsorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventSponsor query()
 * @mixin \Eloquent
 */
	class EventSponsor extends \Eloquent {}
}

namespace Modules\Meetup\Models{
/**
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 * @method static \Modules\Meetup\Database\Factories\EventUserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|EventUser query()
 * @mixin \Eloquent
 */
	class EventUser extends \Eloquent {}
}

namespace Modules\Meetup\Models{
/**
 * @property int $id
 * @property string|null $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $fiscal_code
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property \Spatie\SchemalessAttributes\SchemalessAttributes $extra
 * @property-read string $avatar
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $deviceUsers
 * @property-read int|null $device_users_count
 * @property-read \Modules\User\Models\DeviceProfile|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $devices
 * @property-read int|null $devices_count
 * @property-read string|null $full_name
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\DeviceUser> $mobileDeviceUsers
 * @property-read int|null $mobile_device_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Device> $mobileDevices
 * @property-read int|null $mobile_devices_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read Profile|null $updater
 * @property-read \Modules\User\Models\User|null $user
 * @property-read string|null $user_name
 * @method static Builder<static>|Profile childrenWith(array $relations)
 * @method static Builder<static>|Profile childrenWithCount(array $relations)
 * @method static \Modules\Meetup\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static Builder<static>|Profile permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static Builder<static>|Profile role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereFiscalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUserId($value)
 * @method static Builder<static>|Profile withoutPermission($permissions)
 * @method static Builder<static>|Profile withoutRole($roles, ?string $guard = null)
 * @mixin \Eloquent
 */
	class Profile extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Modules\Notify\Models\Contact.
 *
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property string|null $contact_type
 * @property string|null $value
 * @property string|null $user_id
 * @property string|null $verified_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $token
 * @property string|null $sms_sent_at
 * @property int|null $sms_count
 * @property string|null $mail_sent_at
 * @property int|null $mail_count
 * @property string|null $survey_pdf_id
 * @property string|null $token
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $attribute_1
 * @property string|null $attribute_2
 * @property string|null $attribute_3
 * @property string|null $attribute_4
 * @property string|null $attribute_5
 * @property string|null $attribute_6
 * @property string|null $attribute_7
 * @property string|null $attribute_8
 * @property string|null $attribute_9
 * @property string|null $attribute_10
 * @property string|null $attribute_11
 * @property string|null $attribute_12
 * @property string|null $attribute_13
 * @property string|null $attribute_14
 * @property string|null $usesleft
 * @property string|null $sms_status_code
 * @property string|null $sms_status_txt
 * @property int|null $duplicate_count
 * @property int|null $order_column
 * @method static ContactFactory factory($count = null, $state = [])
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @method static Builder|Contact whereContactType($value)
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereCreatedBy($value)
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereModelId($value)
 * @method static Builder|Contact whereModelType($value)
 * @method static Builder|Contact whereLastName($value)
 * @method static Builder|Contact whereMailCount($value)
 * @method static Builder|Contact whereMailSentAt($value)
 * @method static Builder|Contact whereMobilePhone($value)
 * @method static Builder|Contact whereOrderColumn($value)
 * @method static Builder|Contact whereSmsCount($value)
 * @method static Builder|Contact whereSmsSentAt($value)
 * @method static Builder|Contact whereSmsStatusCode($value)
 * @method static Builder|Contact whereSmsStatusTxt($value)
 * @method static Builder|Contact whereSurveyPdfId($value)
 * @method static Builder|Contact whereToken($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @method static Builder|Contact whereUpdatedBy($value)
 * @method static Builder|Contact whereUserId($value)
 * @method static Builder|Contact whereValue($value)
 * @method static Builder|Contact whereVerifiedAt($value)
 * @mixin Eloquent
 * @property string|null $email
 * @property string|null $mobile_phone
 * @method static Builder|Contact whereAttribute1($value)
 * @method static Builder|Contact whereAttribute10($value)
 * @method static Builder|Contact whereAttribute11($value)
 * @method static Builder|Contact whereAttribute12($value)
 * @method static Builder|Contact whereAttribute13($value)
 * @method static Builder|Contact whereAttribute14($value)
 * @method static Builder|Contact whereAttribute2($value)
 * @method static Builder|Contact whereAttribute3($value)
 * @method static Builder|Contact whereAttribute4($value)
 * @method static Builder|Contact whereAttribute5($value)
 * @method static Builder|Contact whereAttribute6($value)
 * @method static Builder|Contact whereAttribute7($value)
 * @method static Builder|Contact whereAttribute8($value)
 * @method static Builder|Contact whereAttribute9($value)
 * @method static Builder|Contact whereDuplicateCount($value)
 * @method static Builder|Contact whereEmail($value)
 * @method static Builder|Contact whereFirstName($value)
 * @method static Builder|Contact whereUsesleft($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property MediaCollection<int, Media> $media
 * @property int|null $media_count
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder<static>|Contact whereDeletedAt($value)
 * @method static Builder<static>|Contact whereDeletedBy($value)
 * @mixin IdeHelperContact
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Contact extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @property int $id
 * @property string $mailable
 * @property string|null $subject
 * @property string|null $html_layout_path
 * @property string $html_template
 * @property string|null $text_template
 * @property int $version
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property string $name
 * @property string $slug
 * @property array $variables
 * @property mixed $translations
 * @method static Builder<static>|MailTemplate forMailable(Mailable $mailable)
 * @method static Builder<static>|MailTemplate newModelQuery()
 * @method static Builder<static>|MailTemplate newQuery()
 * @method static Builder<static>|MailTemplate query()
 * @method static Builder<static>|MailTemplate whereCreatedAt($value)
 * @method static Builder<static>|MailTemplate whereCreatedBy($value)
 * @method static Builder<static>|MailTemplate whereDeletedAt($value)
 * @method static Builder<static>|MailTemplate whereDeletedBy($value)
 * @method static Builder<static>|MailTemplate whereHtmlTemplate($value)
 * @method static Builder<static>|MailTemplate whereId($value)
 * @method static Builder<static>|MailTemplate whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MailTemplate whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|MailTemplate whereLocale(string $column, string $locale)
 * @method static Builder<static>|MailTemplate whereLocales(string $column, array $locales)
 * @method static Builder<static>|MailTemplate whereMailable($value)
 * @method static Builder<static>|MailTemplate whereName($value)
 * @method static Builder<static>|MailTemplate whereSlug($value)
 * @method static Builder<static>|MailTemplate whereSubject($value)
 * @method static Builder<static>|MailTemplate whereTextTemplate($value)
 * @method static Builder<static>|MailTemplate whereUpdatedAt($value)
 * @method static Builder<static>|MailTemplate whereUpdatedBy($value)
 * @property string|null $params
 * @method static Builder<static>|MailTemplate whereParams($value)
 * @property string|null $sms_template
 * @property string|null $whatsapp_template
 * @property int $counter
 * @method static Builder<static>|MailTemplate whereCounter($value)
 * @method static Builder<static>|MailTemplate whereSmsTemplate($value)
 * @method static Builder<static>|MailTemplate whereWhatsappTemplate($value)
 * @mixin IdeHelperMailTemplate
 * @method static Builder<static>|MailTemplate whereHtmlLayoutPath($value)
 * @method static Builder<static>|MailTemplate whereVersion($value)
 * @mixin \Eloquent
 */
	class MailTemplate extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @property-read ProfileContract|null $creator
 * @property-read Model|\Eloquent $mailable
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read MailTemplate|null $template
 * @property-read ProfileContract|null $updater
 * @method static MailTemplateLogFactory factory($count = null, $state = [])
 * @method static Builder<static>|MailTemplateLog newModelQuery()
 * @method static Builder<static>|MailTemplateLog newQuery()
 * @method static Builder<static>|MailTemplateLog query()
 * @mixin IdeHelperMailTemplateLog
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class MailTemplateLog extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Notification model for the Notify module.
 *
 * @property string $id
 * @property string $type
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property array<string, mixed>|string $data
 * @property Carbon|null $read_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property int|null $tenant_id
 * @property int|null $user_id
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property array<string>|string|null $channels
 * @property string|null $status
 * @property Carbon|null $sent_at
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static NotificationFactory factory($count = null, $state = [])
 * @method static Builder<static>|Notification newModelQuery()
 * @method static Builder<static>|Notification newQuery()
 * @method static Builder<static>|Notification query()
 * @method static Builder<static>|Notification whereCreatedAt($value)
 * @method static Builder<static>|Notification whereCreatedBy($value)
 * @method static Builder<static>|Notification whereData($value)
 * @method static Builder<static>|Notification whereDeletedAt($value)
 * @method static Builder<static>|Notification whereDeletedBy($value)
 * @method static Builder<static>|Notification whereId($value)
 * @method static Builder<static>|Notification whereNotifiableId($value)
 * @method static Builder<static>|Notification whereNotifiableType($value)
 * @method static Builder<static>|Notification whereReadAt($value)
 * @method static Builder<static>|Notification whereType($value)
 * @method static Builder<static>|Notification whereUpdatedAt($value)
 * @method static Builder<static>|Notification whereUpdatedBy($value)
 * @mixin IdeHelperNotification
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Modello per il logging delle notifiche.
 *
 * @property int $id
 * @property int|null $template_id
 * @property string $recipient_type
 * @property int $recipient_id
 * @property string $content
 * @property array $data
 * @property array $channels
 * @property NotificationLogStatusEnum $status
 * @property Carbon|null $sent_at
 * @property Carbon|null $delivered_at
 * @property Carbon|null $opened_at
 * @property Carbon|null $clicked_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read NotificationTemplate|null $template
 * @property string $notifiable_type
 * @property int $notifiable_id
 * @property string $title
 * @property string|null $error
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Model|\Eloquent $notifiable
 * @property-read ProfileContract|null $updater
 * @method static NotificationLogFactory factory($count = null, $state = [])
 * @method static Builder<static>|NotificationLog forNotifiable(Model $notifiable)
 * @method static Builder<static>|NotificationLog forTemplate(int $templateId)
 * @method static Builder<static>|NotificationLog newModelQuery()
 * @method static Builder<static>|NotificationLog newQuery()
 * @method static Builder<static>|NotificationLog query()
 * @method static Builder<static>|NotificationLog whereChannels($value)
 * @method static Builder<static>|NotificationLog whereContent($value)
 * @method static Builder<static>|NotificationLog whereCreatedAt($value)
 * @method static Builder<static>|NotificationLog whereData($value)
 * @method static Builder<static>|NotificationLog whereError($value)
 * @method static Builder<static>|NotificationLog whereId($value)
 * @method static Builder<static>|NotificationLog whereNotifiableId($value)
 * @method static Builder<static>|NotificationLog whereNotifiableType($value)
 * @method static Builder<static>|NotificationLog whereSentAt($value)
 * @method static Builder<static>|NotificationLog whereStatus($value)
 * @method static Builder<static>|NotificationLog whereTitle($value)
 * @method static Builder<static>|NotificationLog whereUpdatedAt($value)
 * @method static Builder<static>|NotificationLog withStatus(NotificationLogStatusEnum $status)
 * @mixin \Eloquent
 */
	final class NotificationLog extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Class NotificationTemplate.
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string $subject
 * @property string|null $body_html
 * @property string|null $body_text
 * @property array $channels
 * @property array $variables
 * @property array|null $conditions
 * @property array|null $preview_data
 * @property array|null $metadata
 * @property string|null $category
 * @property bool $is_active
 * @property int $version
 * @property int|null $tenant_id
 * @property array|null $grapesjs_data
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 * @property-read string $channels_label
 * @property NotificationTypeEnum $type
 * @property-read ProfileContract|null $creator
 * @property-read int|null $logs_count
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read mixed $translations
 * @property-read ProfileContract|null $updater
 * @property-read int|null $versions_count
 * @method static Builder<static>|NotificationTemplate active()
 * @method static NotificationTemplateFactory factory($count = null, $state = [])
 * @method static Builder<static>|NotificationTemplate forCategory(string $category)
 * @method static Builder<static>|NotificationTemplate forChannel(string $channel)
 * @method static Builder<static>|NotificationTemplate newModelQuery()
 * @method static Builder<static>|NotificationTemplate newQuery()
 * @method static Builder<static>|NotificationTemplate query()
 * @method static Builder<static>|NotificationTemplate whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|NotificationTemplate whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|NotificationTemplate whereLocale(string $column, string $locale)
 * @method static Builder<static>|NotificationTemplate whereLocales(string $column, array $locales)
 * @mixin IdeHelperNotificationTemplate
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class NotificationTemplate extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @property-read Profile|null $creator
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read NotificationTemplate|null $template
 * @property-read Profile|null $updater
 * @method static NotificationTemplateVersionFactory factory($count = null, $state = [])
 * @method static Builder<static>|NotificationTemplateVersion newModelQuery()
 * @method static Builder<static>|NotificationTemplateVersion newQuery()
 * @method static Builder<static>|NotificationTemplateVersion query()
 * @mixin IdeHelperNotificationTemplateVersion
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class NotificationTemplateVersion extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * @method static Builder<static>|NotificationType newModelQuery()
 * @method static Builder<static>|NotificationType newQuery()
 * @method static Builder<static>|NotificationType query()
 * @mixin IdeHelperNotificationType
 * @mixin \Eloquent
 */
	class NotificationType extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Modules\Notify\Models\NotifyTheme.
 *
 * @property int $id
 * @property string|null $lang
 * @property string|null $type
 * @property string|null $subject
 * @property string|null $body
 * @property string|null $from
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $post_type
 * @property int|null $post_id
 * @property string|null $body_html
 * @property string|null $theme
 * @property string|null $from_email
 * @property string|null $logo_src
 * @property int|null $logo_width
 * @property int|null $logo_height
 * @property array $view_params
 * @property array $logo
 * @property Model|Eloquent $linkable
 * @property MediaCollection<int, Media> $media
 * @property int|null $media_count
 * @method static NotifyThemeFactory factory($count = null, $state = [])
 * @method static Builder|NotifyTheme newModelQuery()
 * @method static Builder|NotifyTheme newQuery()
 * @method static Builder|NotifyTheme query()
 * @method static Builder|NotifyTheme whereBody($value)
 * @method static Builder|NotifyTheme whereBodyHtml($value)
 * @method static Builder|NotifyTheme whereCreatedAt($value)
 * @method static Builder|NotifyTheme whereCreatedBy($value)
 * @method static Builder|NotifyTheme whereFrom($value)
 * @method static Builder|NotifyTheme whereFromEmail($value)
 * @method static Builder|NotifyTheme whereId($value)
 * @method static Builder|NotifyTheme whereLang($value)
 * @method static Builder|NotifyTheme whereLogoHeight($value)
 * @method static Builder|NotifyTheme whereLogoSrc($value)
 * @method static Builder|NotifyTheme whereLogoWidth($value)
 * @method static Builder|NotifyTheme wherePostId($value)
 * @method static Builder|NotifyTheme wherePostType($value)
 * @method static Builder|NotifyTheme whereSubject($value)
 * @method static Builder|NotifyTheme whereTheme($value)
 * @method static Builder|NotifyTheme whereType($value)
 * @method static Builder|NotifyTheme whereUpdatedAt($value)
 * @method static Builder|NotifyTheme whereUpdatedBy($value)
 * @method static Builder|NotifyTheme whereViewParams($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder<static>|NotifyTheme whereDeletedAt($value)
 * @method static Builder<static>|NotifyTheme whereDeletedBy($value)
 * @mixin IdeHelperNotifyTheme
 * @property-read ProfileContract|null $deleter
 * @mixin Eloquent
 */
	class NotifyTheme extends \Eloquent {}
}

namespace Modules\Notify\Models{
/**
 * Modules\Notify\Models\NotifyThemeable.
 *
 * @property int $id
 * @property string|null $model_type
 * @property int|null $model_id
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property int|null $notify_theme_id
 * @method static Builder|NotifyThemeable newModelQuery()
 * @method static Builder|NotifyThemeable newQuery()
 * @method static Builder|NotifyThemeable query()
 * @method static Builder|NotifyThemeable whereCreatedAt($value)
 * @method static Builder|NotifyThemeable whereCreatedBy($value)
 * @method static Builder|NotifyThemeable whereId($value)
 * @method static Builder|NotifyThemeable whereModelId($value)
 * @method static Builder|NotifyThemeable whereModelType($value)
 * @method static Builder|NotifyThemeable whereNotifyThemeId($value)
 * @method static Builder|NotifyThemeable whereUpdatedAt($value)
 * @method static Builder|NotifyThemeable whereUpdatedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder<static>|NotifyThemeable whereDeletedAt($value)
 * @method static Builder<static>|NotifyThemeable whereDeletedBy($value)
 * @mixin IdeHelperNotifyThemeable
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class NotifyThemeable extends \Eloquent {}
}

namespace Modules\Tenant\Models{
/**
 * @property int|null $id
 * @property string|null $name
 * @method static Builder|Domain newModelQuery()
 * @method static Builder|Domain newQuery()
 * @method static Builder|Domain query()
 * @method static Builder|Domain whereId($value)
 * @method static Builder|Domain whereName($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static DomainFactory factory($count = null, $state = [])
 * @mixin IdeHelperDomain
 * @property ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Domain extends \Eloquent {}
}

namespace Modules\Tenant\Models{
/**
 * Modello Tenant per la gestione multi-tenant dell'applicazione.
 *
 * @property string $name
 * @property string $domain
 * @property string $database
 * @property string $slug
 * @property array|null $settings
 * @property bool $is_active
 * @property string|null $logo
 * @property \Carbon\Carbon|null $last_activity_at
 * @property-read string $url
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 * @method static TenantFactory factory($count = null, $state = [])
 * @method static Builder<static>|Tenant newModelQuery()
 * @method static Builder<static>|Tenant newQuery()
 * @method static Builder<static>|Tenant query()
 * @method static Tenant|null first()
 * @method static Collection<int, Tenant> get()
 * @method static Tenant create(array $attributes = [])
 * @method static Tenant firstOrCreate(array $attributes = [], array $values = [])
 * @method static Builder<static>|Tenant where((string|Closure) $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static Builder<static>|Tenant whereNotNull((string|Expression) $columns)
 * @method static int count(string $columns = '*')
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 * @method static Builder<static>|Tenant whereCreatedAt($value)
 * @method static Builder<static>|Tenant whereDatabase($value)
 * @method static Builder<static>|Tenant whereDeletedAt($value)
 * @method static Builder<static>|Tenant whereDomain($value)
 * @method static Builder<static>|Tenant whereId($value)
 * @method static Builder<static>|Tenant whereIsActive($value)
 * @method static Builder<static>|Tenant whereName($value)
 * @method static Builder<static>|Tenant whereSlug($value)
 * @method static Builder<static>|Tenant whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Tenant extends \Eloquent {}
}

namespace Modules\Tenant\Models{
/**
 * @property int|null $id
 * @property string|int|null $tenant_id
 * @property string|null $name
 * @property string|null $domain
 * @property bool|null $is_primary
 * @property string|null $status
 * @property string|null $verification_token
 * @property \Carbon\Carbon|null $verified_at
 * @method static Builder|TenantDomain newModelQuery()
 * @method static Builder|TenantDomain newQuery()
 * @method static Builder|TenantDomain query()
 * @method static Builder|TenantDomain whereId($value)
 * @method static Builder|TenantDomain whereName($value)
 * @method static Builder|TenantDomain whereDomain($value)
 * @method static Builder|TenantDomain whereIsPrimary($value)
 * @method static Builder|TenantDomain whereStatus($value)
 * @method static Builder|TenantDomain whereVerificationToken($value)
 * @method static Builder|TenantDomain whereVerifiedAt($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 * @method static DomainFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class TenantDomain extends \Eloquent {}
}

namespace Modules\Tenant\Models{
/**
 * @property int|null $id
 * @property string|null $tenant_id
 * @property string|null $key
 * @property string|null $value
 * @property string|null $type
 * @method static Builder|TenantSetting newModelQuery()
 * @method static Builder|TenantSetting newQuery()
 * @method static Builder|TenantSetting query()
 * @method static Builder|TenantSetting whereId($value)
 * @method static Builder|TenantSetting whereTenantId($value)
 * @method static Builder|TenantSetting whereKey($value)
 * @method static Builder|TenantSetting whereValue($value)
 * @method static Builder|TenantSetting whereType($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 * @method static TenantSettingFactory factory($count = null, $state = [])
 * @property-read \Modules\Tenant\Models\Tenant|null $tenant
 * @mixin \Eloquent
 */
	class TenantSetting extends \Eloquent {}
}

namespace Modules\Tenant\Models{
/**
 * @property int|null $id
 * @property string|null $tenant_id
 * @property string|null $plan_name
 * @property string|null $status
 * @property int|null $max_users
 * @property int|null $current_users
 * @property float|null $max_storage_gb
 * @property float|null $current_storage_gb
 * @property string|null $billing_cycle
 * @property float|null $billing_amount
 * @property \Carbon\Carbon|null $next_billing_date
 * @property \Carbon\Carbon|null $expires_at
 * @method static Builder|TenantSubscription newModelQuery()
 * @method static Builder|TenantSubscription newQuery()
 * @method static Builder|TenantSubscription query()
 * @method static Builder|TenantSubscription whereId($value)
 * @method static Builder|TenantSubscription whereTenantId($value)
 * @method static Builder|TenantSubscription wherePlanName($value)
 * @method static Builder|TenantSubscription whereStatus($value)
 * @method static Builder|TenantSubscription whereMaxUsers($value)
 * @method static Builder|TenantSubscription whereCurrentUsers($value)
 * @method static Builder|TenantSubscription whereMaxStorageGb($value)
 * @method static Builder|TenantSubscription whereCurrentStorageGb($value)
 * @method static Builder|TenantSubscription whereBillingCycle($value)
 * @method static Builder|TenantSubscription whereBillingAmount($value)
 * @method static Builder|TenantSubscription whereNextBillingDate($value)
 * @method static Builder|TenantSubscription whereExpiresAt($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 * @method static TenantSubscriptionFactory factory($count = null, $state = [])
 * @property-read \Modules\Tenant\Models\Tenant|null $tenant
 * @mixin \Eloquent
 */
	class TenantSubscription extends \Eloquent {}
}

namespace Modules\Tenant\Models{
/**
 * Modello di test per il trait SushiToJson.
 * 
 * Utilizzato esclusivamente per i test del trait.
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $status
 * @property array<array-key, mixed>|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static TestSushiModelFactory factory($count = null, $state = [])
 * @method static Builder<static>|TestSushiModel newModelQuery()
 * @method static Builder<static>|TestSushiModel newQuery()
 * @method static Builder<static>|TestSushiModel query()
 * @method static Builder<static>|TestSushiModel whereCreatedAt($value)
 * @method static Builder<static>|TestSushiModel whereDescription($value)
 * @method static Builder<static>|TestSushiModel whereId($value)
 * @method static Builder<static>|TestSushiModel whereMetadata($value)
 * @method static Builder<static>|TestSushiModel whereName($value)
 * @method static Builder<static>|TestSushiModel whereStatus($value)
 * @method static Builder<static>|TestSushiModel whereUpdatedAt($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class TestSushiModel extends \Eloquent {}
}

namespace Modules\UI\Models{
/**
 * @property string               $id
 * @property string               $title
 * @property string               $slug
 * @property int|null             $parent_id
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $description
 * @property string|null          $icon
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @property int                  $is_active
 * @property int                  $sort_order
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static CategoryFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Category newModelQuery()
 * @method static Builder<static>|Category newQuery()
 * @method static Builder<static>|Category query()
 * @method static Builder<static>|Category whereCreatedAt($value)
 * @method static Builder<static>|Category whereCreatedBy($value)
 * @method static Builder<static>|Category whereDeletedAt($value)
 * @method static Builder<static>|Category whereDeletedBy($value)
 * @method static Builder<static>|Category whereDescription($value)
 * @method static Builder<static>|Category whereIcon($value)
 * @method static Builder<static>|Category whereId($value)
 * @method static Builder<static>|Category whereIsActive($value)
 * @method static Builder<static>|Category whereParentId($value)
 * @method static Builder<static>|Category whereSlug($value)
 * @method static Builder<static>|Category whereSortOrder($value)
 * @method static Builder<static>|Category whereTitle($value)
 * @method static Builder<static>|Category whereUpdatedAt($value)
 * @method static Builder<static>|Category whereUpdatedBy($value)
 * @property ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

namespace Modules\UI\Models{
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static CollectionFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Collection newModelQuery()
 * @method static Builder<static>|Collection newQuery()
 * @method static Builder<static>|Collection query()
 * @property ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Collection extends \Eloquent {}
}

namespace Modules\UI\Models{
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static FieldOptionFactory          factory($count = null, $state = [])
 * @method static Builder<static>|FieldOption newModelQuery()
 * @method static Builder<static>|FieldOption newQuery()
 * @method static Builder<static>|FieldOption query()
 * @property ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class FieldOption extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Authentication Model.
 * 
 * Tracks user authentication attempts and sessions.
 *
 * @property int         $id
 * @property string      $type                 Type of authentication (e.g., 'login', 'logout')
 * @property string|null $ip_address           IP address used for authentication
 * @property string|null $user_agent           User agent string from the request
 * @property string|null $location             Geographic location derived from IP
 * @property bool        $login_successful     Whether the login attempt was successful
 * @property Carbon|null $login_at             When the login attempt occurred
 * @property Carbon|null $logout_at            When the logout occurred
 * @property string      $authenticatable_type The class name of the authenticatable model
 * @property string      $authenticatable_id   The ID of the authenticatable model
 * @property Carbon|null $created_at           When the record was created
 * @property Carbon|null $updated_at           When the record was last updated
 * @method static Builder<static>|Authentication newModelQuery()
 * @method static Builder<static>|Authentication newQuery()
 * @method static Builder<static>|Authentication query()
 * @method static Builder<static>|Authentication whereCreatedAt($value)
 * @method static Builder<static>|Authentication whereId($value)
 * @method static Builder<static>|Authentication whereIpAddress($value)
 * @method static Builder<static>|Authentication whereLocation($value)
 * @method static Builder<static>|Authentication whereType($value)
 * @method static Builder<static>|Authentication whereUpdatedAt($value)
 * @method static Builder<static>|Authentication whereUserAgent($value)
 * @method static Builder<static>|Authentication whereLoginAt($value)
 * @method static Builder<static>|Authentication whereLogoutAt($value)
 * @method static Builder<static>|Authentication whereLoginSuccessful($value)
 * @method static Builder<static>|Authentication whereAuthenticatableType($value)
 * @method static Builder<static>|Authentication whereAuthenticatableId($value)
 * @mixin IdeHelperAuthentication
 * @property Model|\Eloquent      $authenticatable
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Modules\User\Database\Factories\AuthenticationFactory factory($count = null, $state = [])
 * @method static Builder<static>|Authentication whereCreatedBy($value)
 * @method static Builder<static>|Authentication whereDeletedAt($value)
 * @method static Builder<static>|Authentication whereDeletedBy($value)
 * @method static Builder<static>|Authentication whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Authentication extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property int                  $id
 * @property string               $authenticatable_type
 * @property int                  $authenticatable_id
 * @property string|null          $ip_address
 * @property string|null          $user_agent
 * @property Carbon|null          $login_at
 * @property bool                 $login_successful
 * @property Carbon|null          $logout_at
 * @property bool                 $cleared_by_user
 * @property array|null           $location
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Model|\Eloquent      $authenticatable
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder|AuthenticationLog newModelQuery()
 * @method static Builder|AuthenticationLog newQuery()
 * @method static Builder|AuthenticationLog query()
 * @method static Builder|AuthenticationLog whereAuthenticatableId($value)
 * @method static Builder|AuthenticationLog whereAuthenticatableType($value)
 * @method static Builder|AuthenticationLog whereClearedByUser($value)
 * @method static Builder|AuthenticationLog whereCreatedAt($value)
 * @method static Builder|AuthenticationLog whereCreatedBy($value)
 * @method static Builder|AuthenticationLog whereId($value)
 * @method static Builder|AuthenticationLog whereIpAddress($value)
 * @method static Builder|AuthenticationLog whereLocation($value)
 * @method static Builder|AuthenticationLog whereLoginAt($value)
 * @method static Builder|AuthenticationLog whereLoginSuccessful($value)
 * @method static Builder|AuthenticationLog whereLogoutAt($value)
 * @method static Builder|AuthenticationLog whereUpdatedAt($value)
 * @method static Builder|AuthenticationLog whereUpdatedBy($value)
 * @method static Builder|AuthenticationLog whereUserAgent($value)
 * @mixin IdeHelperAuthenticationLog
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\AuthenticationLogFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class AuthenticationLog extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Device model representing a user's device in the system.
 *
 * @property EloquentCollection<int, Model&UserContract> $users
 * @property int|null                                    $users_count
 * @method static Builder|Device newModelQuery()
 * @method static Builder|Device newQuery()
 * @method static Builder|Device query()
 * @method static Builder|Device whereBrowser($value)
 * @method static Builder|Device whereCreatedAt($value)
 * @method static Builder|Device whereCreatedBy($value)
 * @method static Builder|Device whereDevice($value)
 * @method static Builder|Device whereId($value)
 * @method static Builder|Device whereIsDesktop($value)
 * @method static Builder|Device whereIsMobile($value)
 * @method static Builder|Device whereIsPhone($value)
 * @method static Builder|Device whereIsRobot($value)
 * @method static Builder|Device whereIsTablet($value)
 * @method static Builder|Device whereLanguages($value)
 * @method static Builder|Device whereMobileId($value)
 * @method static Builder|Device wherePlatform($value)
 * @method static Builder|Device whereRobot($value)
 * @method static Builder|Device whereUpdatedAt($value)
 * @method static Builder|Device whereUpdatedBy($value)
 * @method static Builder|Device whereVersion($value)
 * @property DeviceUser           $pivot
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string               $id
 * @property string|null          $mobile_id
 * @property array|null           $languages
 * @property string|null          $device
 * @property string|null          $platform
 * @property string|null          $browser
 * @property string|null          $version
 * @property bool|null            $is_robot
 * @property string|null          $robot
 * @property bool|null            $is_desktop
 * @property bool|null            $is_mobile
 * @property bool|null            $is_tablet
 * @property bool|null            $is_phone
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property string|null          $uuid
 * @method static Builder<static>|Device whereUuid($value)
 * @mixin IdeHelperDevice
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\DeviceFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Device extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * DeviceProfile Model.
 * 
 * Represents the relationship between a device and a user profile.
 * Extends the base DeviceUser model to add specific functionality.
 *
 * @property ProfileContract|null $creator
 * @property Device|null          $device
 * @property ProfileContract|null $profile
 * @property ProfileContract|null $updater
 * @property User|null            $user
 * @method static Builder<static>|DeviceProfile newModelQuery()
 * @method static Builder<static>|DeviceProfile newQuery()
 * @method static Builder<static>|DeviceProfile query()
 * @mixin IdeHelperDeviceProfile
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\DeviceProfileFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class DeviceProfile extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\DeviceUser.
 *
 * @property Device|null $device
 * @method static Builder|DeviceUser newModelQuery()
 * @method static Builder|DeviceUser newQuery()
 * @method static Builder|DeviceUser query()
 * @property string      $id
 * @property string      $device_id
 * @property string      $user_id
 * @property Carbon|null $login_at
 * @property Carbon|null $logout_at
 * @property string|null $push_notifications_token
 * @property bool|null   $push_notifications_enabled
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder|DeviceUser whereCreatedAt($value)
 * @method static Builder|DeviceUser whereCreatedBy($value)
 * @method static Builder|DeviceUser whereDeviceId($value)
 * @method static Builder|DeviceUser whereId($value)
 * @method static Builder|DeviceUser whereLoginAt($value)
 * @method static Builder|DeviceUser whereLogoutAt($value)
 * @method static Builder|DeviceUser wherePushNotificationsEnabled($value)
 * @method static Builder|DeviceUser wherePushNotificationsToken($value)
 * @method static Builder|DeviceUser whereUpdatedAt($value)
 * @method static Builder|DeviceUser whereUpdatedBy($value)
 * @method static Builder|DeviceUser whereUserId($value)
 * @property ProfileContract|null $profile
 * @property UserContract|null    $user
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperDeviceUser
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\DeviceUserFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class DeviceUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property SchemalessAttributes $extra_attributes
 * @method static Builder|Extra newModelQuery()
 * @method static Builder|Extra newQuery()
 * @method static Builder|Extra query()
 * @method static Builder|Extra withExtraAttributes()
 * @property int         $id
 * @property string      $model_type
 * @property string      $model_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder|Extra whereCreatedAt($value)
 * @method static Builder|Extra whereCreatedBy($value)
 * @method static Builder|Extra whereDeletedAt($value)
 * @method static Builder|Extra whereDeletedBy($value)
 * @method static Builder|Extra whereExtraAttributes($value)
 * @method static Builder|Extra whereId($value)
 * @method static Builder|Extra whereModelId($value)
 * @method static Builder|Extra whereModelType($value)
 * @method static Builder|Extra whereUpdatedAt($value)
 * @method static Builder|Extra whereUpdatedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperExtra
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\ExtraFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	final class Extra extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder|Feature newModelQuery()
 * @method static Builder|Feature newQuery()
 * @method static Builder|Feature query()
 * @property string      $id
 * @property string      $name
 * @property string      $scope
 * @property string      $value
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder|Feature whereCreatedAt($value)
 * @method static Builder|Feature whereCreatedBy($value)
 * @method static Builder|Feature whereDeletedAt($value)
 * @method static Builder|Feature whereDeletedBy($value)
 * @method static Builder|Feature whereId($value)
 * @method static Builder|Feature whereName($value)
 * @method static Builder|Feature whereScope($value)
 * @method static Builder|Feature whereUpdatedAt($value)
 * @method static Builder|Feature whereUpdatedBy($value)
 * @method static Builder|Feature whereValue($value)
 * @mixin IdeHelperFeature
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\FeatureFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Feature extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\Membership.
 *
 * @property string $role
 * @method static Builder|Membership newModelQuery()
 * @method static Builder|Membership newQuery()
 * @method static Builder|Membership query()
 * @property int         $id
 * @property string|null $team_id
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $customer_id
 * @method static Builder|Membership whereCreatedAt($value)
 * @method static Builder|Membership whereCreatedBy($value)
 * @method static Builder|Membership whereCustomerId($value)
 * @method static Builder|Membership whereRole($value)
 * @method static Builder|Membership whereTeamId($value)
 * @method static Builder|Membership whereUpdatedAt($value)
 * @method static Builder|Membership whereUpdatedBy($value)
 * @method static Builder|Membership whereUserId($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder|Membership whereDeletedAt($value)
 * @method static Builder|Membership whereDeletedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperMembership
 * @property ProfileContract|null $deleter
 * @method static Builder<static>|Membership whereId($value)
 * @property array<array-key, mixed>|null $permissions
 * @property string|null $joined_at
 * @method static Builder<static>|Membership whereJoinedAt($value)
 * @method static Builder<static>|Membership wherePermissions($value)
 * @mixin \Eloquent
 */
	class Membership extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\ModelHasPermission.
 *
 * @property int    $id
 * @property int    $permission_id
 * @property string $model_type
 * @property string $model_id
 * @method static Builder|ModelHasPermission newModelQuery()
 * @method static Builder|ModelHasPermission newQuery()
 * @method static Builder|ModelHasPermission query()
 * @method static Builder|ModelHasPermission whereId($value)
 * @method static Builder|ModelHasPermission whereModelId($value)
 * @method static Builder|ModelHasPermission whereModelType($value)
 * @method static Builder|ModelHasPermission wherePermissionId($value)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder|ModelHasPermission whereCreatedAt($value)
 * @method static Builder|ModelHasPermission whereCreatedBy($value)
 * @method static Builder|ModelHasPermission whereUpdatedAt($value)
 * @method static Builder|ModelHasPermission whereUpdatedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string|null          $team_id
 * @method static Builder|ModelHasPermission whereTeamId($value)
 * @mixin IdeHelperModelHasPermission
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\ModelHasPermissionFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class ModelHasPermission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\ModelHasRole.
 *
 * @property string      $id
 * @property string      $role_id
 * @property string      $model_type
 * @property string      $model_id
 * @property int|null    $team_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder|ModelHasRole newModelQuery()
 * @method static Builder|ModelHasRole newQuery()
 * @method static Builder|ModelHasRole query()
 * @method static Builder|ModelHasRole whereCreatedAt($value)
 * @method static Builder|ModelHasRole whereCreatedBy($value)
 * @method static Builder|ModelHasRole whereId($value)
 * @method static Builder|ModelHasRole whereModelId($value)
 * @method static Builder|ModelHasRole whereModelType($value)
 * @method static Builder|ModelHasRole whereRoleId($value)
 * @method static Builder|ModelHasRole whereTeamId($value)
 * @method static Builder|ModelHasRole whereUpdatedAt($value)
 * @method static Builder|ModelHasRole whereUpdatedBy($value)
 * @property string $uuid (DC2Type:guid)
 * @method static Builder|ModelHasRole whereUuid($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperModelHasRole
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\ModelHasRoleFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class ModelHasRole extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\ModelHasRole.
 *
 * @property string      $id
 * @property string      $role_id
 * @property string      $model_type
 * @property string      $model_id
 * @property int|null    $team_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder|ModelHasRole newModelQuery()
 * @method static Builder|ModelHasRole newQuery()
 * @method static Builder|ModelHasRole query()
 * @method static Builder|ModelHasRole whereCreatedAt($value)
 * @method static Builder|ModelHasRole whereCreatedBy($value)
 * @method static Builder|ModelHasRole whereId($value)
 * @method static Builder|ModelHasRole whereModelId($value)
 * @method static Builder|ModelHasRole whereModelType($value)
 * @method static Builder|ModelHasRole whereRoleId($value)
 * @method static Builder|ModelHasRole whereTeamId($value)
 * @method static Builder|ModelHasRole whereUpdatedAt($value)
 * @method static Builder|ModelHasRole whereUpdatedBy($value)
 * @property string $uuid (DC2Type:guid)
 * @method static Builder|ModelHasRole whereUuid($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperModelHasRole
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\ModelRoleFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class ModelRole extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property Model|\Eloquent $notifiable
 * @method static DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static Builder|Notification                        newModelQuery()
 * @method static Builder|Notification                        newQuery()
 * @method static Builder|Notification                        query()
 * @method static Builder|Notification                        read()
 * @method static Builder|Notification                        unread()
 * @method static DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @method static DatabaseNotificationCollection<int, static> all($columns = ['*'])
 * @method static DatabaseNotificationCollection<int, static> get($columns = ['*'])
 * @mixin IdeHelperNotification
 * @method static \Modules\User\Database\Factories\NotificationFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Notification extends \Eloquent {}
}

namespace Modules\User\Models\Passport{
/**
 * Custom Passport Client model to fix compatibility issues with Laravel 12.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\OauthAuthCode> $authCodes
 * @property-read int|null $auth_codes_count
 * @property-read array $grant_types
 * @property-read \Illuminate\Foundation\Auth\User $owner
 * @property-read string|null $plain_secret
 * @property-read array $redirect_uris
 * @property-write string|null $secret
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\User\Models\OauthToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Modules\User\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client existsIn(array $haystack)
 * @method static \Laravel\Passport\Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client query()
 * @mixin \Eloquent
 */
	class Client extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\PasswordReset.
 *
 * @property int         $id
 * @property string      $email
 * @property string      $token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $user_id
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder|PasswordReset newModelQuery()
 * @method static Builder|PasswordReset newQuery()
 * @method static Builder|PasswordReset query()
 * @method static Builder|PasswordReset whereCreatedAt($value)
 * @method static Builder|PasswordReset whereCreatedBy($value)
 * @method static Builder|PasswordReset whereEmail($value)
 * @method static Builder|PasswordReset whereId($value)
 * @method static Builder|PasswordReset whereToken($value)
 * @method static Builder|PasswordReset whereUpdatedAt($value)
 * @method static Builder|PasswordReset whereUpdatedBy($value)
 * @method static Builder|PasswordReset whereUserId($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string|null          $uuid
 * @method static Builder<static>|PasswordReset whereUuid($value)
 * @mixin IdeHelperPasswordReset
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\PasswordResetFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class PasswordReset extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property int                         $id
 * @property string                      $name
 * @property string                      $guard_name
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property string|null                 $updated_by
 * @property string|null                 $created_by
 * @property Collection<int, Permission> $permissions
 * @property int|null                    $permissions_count
 * @property Collection<int, Role>       $roles
 * @property int|null                    $roles_count
 * @property Collection<int, User>       $users
 * @property int|null                    $users_count
 * @method static Builder<static>|Permission newModelQuery()
 * @method static Builder<static>|Permission newQuery()
 * @method static Builder<static>|Permission permission($permissions, $without = false)
 * @method static Builder<static>|Permission query()
 * @method static Builder<static>|Permission role($roles, $guard = null, $without = false)
 * @method static Builder<static>|Permission whereCreatedAt($value)
 * @method static Builder<static>|Permission whereCreatedBy($value)
 * @method static Builder<static>|Permission whereGuardName($value)
 * @method static Builder<static>|Permission whereId($value)
 * @method static Builder<static>|Permission whereName($value)
 * @method static Builder<static>|Permission whereUpdatedAt($value)
 * @method static Builder<static>|Permission whereUpdatedBy($value)
 * @method static Builder<static>|Permission withoutPermission($permissions)
 * @method static Builder<static>|Permission withoutRole($roles, $guard = null)
 * @method static static                     firstOrCreate(array $attributes, array $values = [])
 * @method static static                     updateOrCreate(array $attributes, array $values = [])
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 * @method static \Modules\User\Database\Factories\PermissionFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Permission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder|PermissionRole newModelQuery()
 * @method static Builder|PermissionRole newQuery()
 * @method static Builder|PermissionRole query()
 * @property string      $id
 * @property string|null $permission_id
 * @property string|null $role_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder|PermissionRole whereCreatedAt($value)
 * @method static Builder|PermissionRole whereCreatedBy($value)
 * @method static Builder|PermissionRole whereId($value)
 * @method static Builder|PermissionRole wherePermissionId($value)
 * @method static Builder|PermissionRole whereRoleId($value)
 * @method static Builder|PermissionRole whereUpdatedAt($value)
 * @method static Builder|PermissionRole whereUpdatedBy($value)
 * @mixin IdeHelperPermissionRole
 * @property ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class PermissionRole extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder<static>|PermissionUser newModelQuery()
 * @method static Builder<static>|PermissionUser newQuery()
 * @method static Builder<static>|PermissionUser query()
 * @mixin IdeHelperPermissionUser
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\PermissionUserFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class PermissionUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\PersonalAccessToken.
 *
 * @property int                             $id
 * @property string                          $tokenable_type
 * @property int                             $tokenable_id
 * @property string                          $name
 * @property string                          $token
 * @property string|null                     $abilities
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\User\Database\Factories\PersonalAccessTokenFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonalAccessToken whereTokenableType($value)
 * @mixin \Eloquent
 */
	class PersonalAccessToken extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * User Profile Model.
 * 
 * Represents a user profile with relationships to devices, teams, and roles.
 *
 * @property int                                                       $id
 * @property string                                                    $first_name
 * @property string                                                    $last_name
 * @property string                                                    $user_name
 * @property string                                                    $email
 * @property string|null                                               $phone
 * @property string|null                                               $bio
 * @property string|null                                               $avatar
 * @property string|null                                               $timezone
 * @property string|null                                               $locale
 * @property array                                                     $preferences
 * @property string                                                    $status
 * @property SchemalessAttributes                                      $extra
 * @property string                                                    $avatar
 * @property ProfileContract|null                                      $creator
 * @property Collection<int, DeviceUser>                               $deviceUsers
 * @property int|null                                                  $device_users_count
 * @property ProfileTeam|DeviceProfile|null                            $pivot
 * @property Collection<int, Device>                                   $devices
 * @property int|null                                                  $devices_count
 * @property string|null                                               $first_name
 * @property string|null                                               $full_name
 * @property string|null                                               $last_name
 * @property MediaCollection<int, Media>                               $media
 * @property int|null                                                  $media_count
 * @property Collection<int, DeviceUser>                               $mobileDeviceUsers
 * @property int|null                                                  $mobile_device_users_count
 * @property Collection<int, Device>                                   $mobileDevices
 * @property int|null                                                  $mobile_devices_count
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property int|null                                                  $notifications_count
 * @property Collection<int, Permission>                               $permissions
 * @property int|null                                                  $permissions_count
 * @property Collection<int, Role>                                     $roles
 * @property int|null                                                  $roles_count
 * @property Collection<int, Team>                                     $teams
 * @property int|null                                                  $teams_count
 * @property ProfileContract|null                                      $updater
 * @property UserContract|null                                         $user
 * @property string|null                                               $user_name
 * @method static Builder<static>|Profile newModelQuery()
 * @method static Builder<static>|Profile newQuery()
 * @method static Builder<static>|Profile permission($permissions, $without = false)
 * @method static Builder<static>|Profile query()
 * @method static Builder<static>|Profile role($roles, $guard = null, $without = false)
 * @method static Builder<static>|Profile withExtraAttributes()
 * @method static Builder<static>|Profile withoutPermission($permissions)
 * @method static Builder<static>|Profile withoutRole($roles, $guard = null)
 * @mixin IdeHelperProfile
 * @property string|null          $user_id
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @property ProfileContract|null $deleter
 * @method static Builder<static>|Profile whereBio($value)
 * @method static Builder<static>|Profile whereCreatedAt($value)
 * @method static Builder<static>|Profile whereCreatedBy($value)
 * @method static Builder<static>|Profile whereDeletedAt($value)
 * @method static Builder<static>|Profile whereDeletedBy($value)
 * @method static Builder<static>|Profile whereEmail($value)
 * @method static Builder<static>|Profile whereFirstName($value)
 * @method static Builder<static>|Profile whereId($value)
 * @method static Builder<static>|Profile whereLastName($value)
 * @method static Builder<static>|Profile wherePhone($value)
 * @method static Builder<static>|Profile whereUpdatedAt($value)
 * @method static Builder<static>|Profile whereUpdatedBy($value)
 * @method static Builder<static>|Profile whereUserId($value)
 * @property string|null $type
 * @property string|null $address
 * @property string|null $birth_date
 * @property string|null $gender
 * @property bool $is_active
 * @method static Builder<static>|Profile childrenWith(array $relations)
 * @method static Builder<static>|Profile childrenWithCount(array $relations)
 * @method static \Modules\User\Database\Factories\ProfileFactory factory($count = null, $state = [])
 * @method static Builder<static>|Profile whereAddress($value)
 * @method static Builder<static>|Profile whereAvatar($value)
 * @method static Builder<static>|Profile whereBirthDate($value)
 * @method static Builder<static>|Profile whereExtra($value)
 * @method static Builder<static>|Profile whereGender($value)
 * @method static Builder<static>|Profile whereIsActive($value)
 * @method static Builder<static>|Profile whereLocale($value)
 * @method static Builder<static>|Profile wherePreferences($value)
 * @method static Builder<static>|Profile whereStatus($value)
 * @method static Builder<static>|Profile whereTimezone($value)
 * @method static Builder<static>|Profile whereType($value)
 * @method static Builder<static>|Profile whereUserName($value)
 * @mixin \Eloquent
 */
	class Profile extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * ProfileTeam Model.
 * 
 * Represents the relationship between a profile and a team, including the user's role.
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string               $id
 * @property int                  $team_id
 * @property string|null          $user_id
 * @property string|null          $role
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property string|null          $updated_by
 * @property string|null          $created_by
 * @property Carbon|null          $deleted_at
 * @property string|null          $deleted_by
 * @method static Builder<static>|ProfileTeam newModelQuery()
 * @method static Builder<static>|ProfileTeam newQuery()
 * @method static Builder<static>|ProfileTeam query()
 * @method static Builder<static>|ProfileTeam whereCreatedAt($value)
 * @method static Builder<static>|ProfileTeam whereCreatedBy($value)
 * @method static Builder<static>|ProfileTeam whereDeletedAt($value)
 * @method static Builder<static>|ProfileTeam whereDeletedBy($value)
 * @method static Builder<static>|ProfileTeam whereId($value)
 * @method static Builder<static>|ProfileTeam whereRole($value)
 * @method static Builder<static>|ProfileTeam whereTeamId($value)
 * @method static Builder<static>|ProfileTeam whereUpdatedAt($value)
 * @method static Builder<static>|ProfileTeam whereUpdatedBy($value)
 * @method static Builder<static>|ProfileTeam whereUserId($value)
 * @mixin IdeHelperProfileTeam
 * @property ProfileContract|null $deleter
 * @property Team|null            $team
 * @property User|null            $user
 * @property string|null $profile_id
 * @property array<array-key, mixed>|null $permissions
 * @method static Builder<static>|ProfileTeam childrenWith(array $relations)
 * @method static Builder<static>|ProfileTeam childrenWithCount(array $relations)
 * @method static \Modules\User\Database\Factories\ProfileTeamFactory factory($count = null, $state = [])
 * @method static Builder<static>|ProfileTeam wherePermissions($value)
 * @method static Builder<static>|ProfileTeam whereProfileId($value)
 * @mixin \Eloquent
 */
	class ProfileTeam extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\Role.
 *
 * @property int                                                        $id
 * @property string                                                     $uuid
 * @property string|null                                                $team_id
 * @property string                                                     $name
 * @property string                                                     $guard_name
 * @property string|null                                                $display_name
 * @property string|null                                                $description
 * @property Carbon|null                                                $created_at
 * @property Carbon|null                                                $updated_at
 * @property string|null                                                $updated_by
 * @property string|null                                                $created_by
 * @property Collection<int, Permission>                                $permissions
 * @property int|null                                                   $permissions_count
 * @property Team|null                                                  $team
 * @property Collection<int, Model&\Modules\Xot\Contracts\UserContract> $users
 * @property int|null                                                   $users_count
 * @property PermissionRole|null                                        $pivot
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereTeamId($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereCreatedBy($value)
 * @method static Builder|Role whereUpdatedBy($value)
 * @method static Builder|Role withoutPermission($permissions)
 * @method static Builder|Role whereDescription($value)
 * @method static Builder|Role whereDisplayName($value)
 * @method static static       firstOrCreate(array $attributes, array $values = [])
 * @method static static       updateOrCreate(array $attributes, array $values = [])
 * @property-read \Modules\Meetup\Models\Profile|null $creator
 * @property-read \Modules\Meetup\Models\Profile|null $deleter
 * @property-read \Modules\Meetup\Models\Profile|null $updater
 * @method static \Modules\User\Database\Factories\RoleFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class Role extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\RoleHasPermission.
 *
 * @property int $id
 * @property int $permission_id
 * @property int $role_id
 * @method static Builder|RoleHasPermission newModelQuery()
 * @method static Builder|RoleHasPermission newQuery()
 * @method static Builder|RoleHasPermission query()
 * @method static Builder|RoleHasPermission whereId($value)
 * @method static Builder|RoleHasPermission wherePermissionId($value)
 * @method static Builder|RoleHasPermission whereRoleId($value)
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder|RoleHasPermission whereCreatedAt($value)
 * @method static Builder|RoleHasPermission whereCreatedBy($value)
 * @method static Builder|RoleHasPermission whereUpdatedAt($value)
 * @method static Builder|RoleHasPermission whereUpdatedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperRoleHasPermission
 * @property ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class RoleHasPermission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * @property int|null             $id
 * @property string|null          $name
 * @property array|null           $scopes
 * @property array|null           $parameters
 * @property bool|null            $stateless
 * @property bool|null            $active
 * @property bool|null            $socialite
 * @property string|null          $svg
 * @property string|null          $client_id
 * @property string|null          $client_secret
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Builder|SocialProvider newModelQuery()
 * @method static Builder|SocialProvider newQuery()
 * @method static Builder|SocialProvider query()
 * @method static Builder|SocialProvider whereActive($value)
 * @method static Builder|SocialProvider whereClientId($value)
 * @method static Builder|SocialProvider whereClientSecret($value)
 * @method static Builder|SocialProvider whereId($value)
 * @method static Builder|SocialProvider whereName($value)
 * @method static Builder|SocialProvider whereParameters($value)
 * @method static Builder|SocialProvider whereScopes($value)
 * @method static Builder|SocialProvider whereSocialite($value)
 * @method static Builder|SocialProvider whereStateless($value)
 * @method static Builder|SocialProvider whereSvg($value)
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static Builder|SocialProvider whereCreatedAt($value)
 * @method static Builder|SocialProvider whereCreatedBy($value)
 * @method static Builder|SocialProvider whereUpdatedAt($value)
 * @method static Builder|SocialProvider whereUpdatedBy($value)
 * @mixin IdeHelperSocialProvider
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\SocialProviderFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class SocialProvider extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\SocialiteUser.
 *
 * @property int               $id
 * @property string            $user_id
 * @property string            $provider
 * @property string            $provider_id
 * @property string|null       $token
 * @property string|null       $name
 * @property string|null       $email
 * @property string|null       $avatar
 * @property Carbon|null       $created_at
 * @property Carbon|null       $updated_at
 * @property string|null       $updated_by
 * @property string|null       $created_by
 * @property UserContract|null $user
 * @method static Builder|SocialiteUser newModelQuery()
 * @method static Builder|SocialiteUser newQuery()
 * @method static Builder|SocialiteUser query()
 * @method static Builder|SocialiteUser whereAvatar($value)
 * @method static Builder|SocialiteUser whereCreatedAt($value)
 * @method static Builder|SocialiteUser whereCreatedBy($value)
 * @method static Builder|SocialiteUser whereEmail($value)
 * @method static Builder|SocialiteUser whereId($value)
 * @method static Builder|SocialiteUser whereName($value)
 * @method static Builder|SocialiteUser whereProvider($value)
 * @method static Builder|SocialiteUser whereProviderId($value)
 * @method static Builder|SocialiteUser whereToken($value)
 * @method static Builder|SocialiteUser whereUpdatedAt($value)
 * @method static Builder|SocialiteUser whereUpdatedBy($value)
 * @method static Builder|SocialiteUser whereUserId($value)
 * @property string $uuid (DC2Type:guid)
 * @method static Builder|SocialiteUser whereUuid($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperSocialiteUser
 * @property ProfileContract|null $deleter
 * @method static \Modules\User\Database\Factories\SocialiteUserFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class SocialiteUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\SsoProvider.
 *
 * @property int         $id
 * @property string      $name
 * @property string      $display_name
 * @property string      $type
 * @property string|null $entity_id
 * @property string|null $client_id
 * @property string|null $client_secret
 * @property string|null $redirect_url
 * @property string|null $metadata_url
 * @property string|null $scopes
 * @property array|null  $settings
 * @property array|null  $domain_whitelist
 * @property array|null  $role_mapping
 * @property bool        $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @mixin IdeHelperSsoProvider
 * @property Collection<int, User> $users
 * @property int|null              $users_count
 * @method static Builder<static>|SsoProvider newModelQuery()
 * @method static Builder<static>|SsoProvider newQuery()
 * @method static Builder<static>|SsoProvider query()
 * @method static Builder<static>|SsoProvider whereClientId($value)
 * @method static Builder<static>|SsoProvider whereClientSecret($value)
 * @method static Builder<static>|SsoProvider whereCreatedAt($value)
 * @method static Builder<static>|SsoProvider whereCreatedBy($value)
 * @method static Builder<static>|SsoProvider whereDisplayName($value)
 * @method static Builder<static>|SsoProvider whereDomainWhitelist($value)
 * @method static Builder<static>|SsoProvider whereEntityId($value)
 * @method static Builder<static>|SsoProvider whereId($value)
 * @method static Builder<static>|SsoProvider whereIsActive($value)
 * @method static Builder<static>|SsoProvider whereMetadataUrl($value)
 * @method static Builder<static>|SsoProvider whereName($value)
 * @method static Builder<static>|SsoProvider whereRedirectUrl($value)
 * @method static Builder<static>|SsoProvider whereRoleMapping($value)
 * @method static Builder<static>|SsoProvider whereScopes($value)
 * @method static Builder<static>|SsoProvider whereSettings($value)
 * @method static Builder<static>|SsoProvider whereType($value)
 * @method static Builder<static>|SsoProvider whereUpdatedAt($value)
 * @method static Builder<static>|SsoProvider whereUpdatedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\SsoProviderFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class SsoProvider extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Class Modules\User\Models\Team.
 *
 * @property string                          $id
 * @property string                          $user_id                (DC2Type:guid)
 * @property string                          $name
 * @property int                             $personal_team
 * @property Carbon|null                     $created_at
 * @property Carbon|null                     $updated_at
 * @property string|null                     $updated_by
 * @property string|null                     $created_by
 * @property Carbon|null                     $deleted_at
 * @property string|null                     $deleted_by
 * @property ProfileContract|null            $creator
 * @property TeamUser                        $pivot
 * @property Collection<int, User>           $members
 * @property int|null                        $members_count
 * @property User|null                       $owner
 * @property Collection<int, TeamInvitation> $teamInvitations
 * @property int|null                        $team_invitations_count
 * @property ProfileContract|null            $updater
 * @property Collection<int, User>           $users
 * @property int|null                        $users_count
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereCreatedBy($value)
 * @method static Builder|Team whereDeletedAt($value)
 * @method static Builder|Team whereDeletedBy($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team wherePersonalTeam($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @method static Builder|Team whereUpdatedBy($value)
 * @method static Builder|Team whereUserId($value)
 * @property string|null $code
 * @method static Builder|Team whereCode($value)
 * @property string|null $uuid
 * @method static Builder<static>|Team whereUuid($value)
 * @property string|null $owner_id
 * @method static Builder<static>|Team whereOwnerId($value)
 * @method static static               create(array $attributes = [])
 * @method static static               firstOrCreate(array $attributes, array $values = [])
 * @method static static               updateOrCreate(array $attributes, array $values = [])
 * @mixin IdeHelperTeam
 * @property ProfileContract|null $deleter
 * @property string|null $slug
 * @property string|null $description
 * @property string|null $avatar_path
 * @property array<array-key, mixed>|null $settings
 * @property-read Collection<int, \Modules\User\Models\TeamPermission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, \Modules\User\Models\TeamUser> $teamUsers
 * @property-read int|null $team_users_count
 * @method static \Modules\User\Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static Builder<static>|Team whereAvatarPath($value)
 * @method static Builder<static>|Team whereDescription($value)
 * @method static Builder<static>|Team whereSettings($value)
 * @method static Builder<static>|Team whereSlug($value)
 * @mixin \Eloquent
 */
	class Team extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\TeamInvitation.
 *
 * @property int               $id
 * @property string|null       $team_id
 * @property string            $email
 * @property string|null       $role
 * @property Carbon|null       $created_at
 * @property Carbon|null       $updated_at
 * @property Team|null         $team
 * @property TeamContract|null $team
 * @method static Builder|TeamInvitation newModelQuery()
 * @method static Builder|TeamInvitation newQuery()
 * @method static Builder|TeamInvitation query()
 * @method static Builder|TeamInvitation whereCreatedAt($value)
 * @method static Builder|TeamInvitation whereEmail($value)
 * @method static Builder|TeamInvitation whereId($value)
 * @method static Builder|TeamInvitation whereRole($value)
 * @method static Builder|TeamInvitation whereTeamId($value)
 * @method static Builder|TeamInvitation whereUpdatedAt($value)
 * @property string      $uuid
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder|TeamInvitation whereCreatedBy($value)
 * @method static Builder|TeamInvitation whereDeletedAt($value)
 * @method static Builder|TeamInvitation whereDeletedBy($value)
 * @method static Builder|TeamInvitation whereUpdatedBy($value)
 * @method static Builder|TeamInvitation whereUuid($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperTeamInvitation
 * @property ProfileContract|null $deleter
 * @property Carbon|null $accepted_at
 * @property Carbon|null $declined_at
 * @property string|null $user_id
 * @method static \Modules\User\Database\Factories\TeamInvitationFactory factory($count = null, $state = [])
 * @method static Builder<static>|TeamInvitation whereAcceptedAt($value)
 * @method static Builder<static>|TeamInvitation whereDeclinedAt($value)
 * @method static Builder<static>|TeamInvitation whereUserId($value)
 * @mixin \Eloquent
 */
	class TeamInvitation extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Team Permission Model.
 * 
 * Represents a permission assigned to a user within a team context.
 *
 * @property string         $id
 * @property string         $team_id
 * @property string         $user_id
 * @property string         $permission
 * @property \DateTime|null $created_at
 * @property \DateTime|null $updated_at
 * @property Team           $team
 * @property User           $user
 * @method static Builder<static>|TeamPermission newModelQuery()
 * @method static Builder<static>|TeamPermission newQuery()
 * @method static Builder<static>|TeamPermission query()
 * @mixin IdeHelperTeamPermission
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 * @property string|null $name
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static \Modules\User\Database\Factories\TeamPermissionFactory factory($count = null, $state = [])
 * @method static Builder<static>|TeamPermission whereCreatedAt($value)
 * @method static Builder<static>|TeamPermission whereCreatedBy($value)
 * @method static Builder<static>|TeamPermission whereDeletedAt($value)
 * @method static Builder<static>|TeamPermission whereDeletedBy($value)
 * @method static Builder<static>|TeamPermission whereId($value)
 * @method static Builder<static>|TeamPermission whereName($value)
 * @method static Builder<static>|TeamPermission wherePermission($value)
 * @method static Builder<static>|TeamPermission whereTeamId($value)
 * @method static Builder<static>|TeamPermission whereUpdatedAt($value)
 * @method static Builder<static>|TeamPermission whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class TeamPermission extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\TeamUser.
 *
 * @method static Builder|TeamUser newModelQuery()
 * @method static Builder|TeamUser newQuery()
 * @method static Builder|TeamUser query()
 * @property int         $id
 * @property string      $uuid
 * @property string|null $team_id
 * @property string|null $user_id
 * @property string|null $role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $customer_id
 * @method static Builder|TeamUser whereCreatedAt($value)
 * @method static Builder|TeamUser whereCreatedBy($value)
 * @method static Builder|TeamUser whereCustomerId($value)
 * @method static Builder|TeamUser whereId($value)
 * @method static Builder|TeamUser whereRole($value)
 * @method static Builder|TeamUser whereTeamId($value)
 * @method static Builder|TeamUser whereUpdatedAt($value)
 * @method static Builder|TeamUser whereUpdatedBy($value)
 * @method static Builder|TeamUser whereUserId($value)
 * @method static Builder|TeamUser whereUuid($value)
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder|TeamUser whereDeletedAt($value)
 * @method static Builder|TeamUser whereDeletedBy($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @mixin IdeHelperTeamUser
 * @property ProfileContract|null $deleter
 * @property Team|null            $team
 * @property User|null            $user
 * @property array<array-key, mixed>|null $permissions
 * @property string|null $joined_at
 * @method static Builder<static>|TeamUser childrenWith(array $relations)
 * @method static Builder<static>|TeamUser childrenWithCount(array $relations)
 * @method static \Modules\User\Database\Factories\TeamUserFactory factory($count = null, $state = [])
 * @method static Builder<static>|TeamUser whereJoinedAt($value)
 * @method static Builder<static>|TeamUser wherePermissions($value)
 * @mixin \Eloquent
 */
	class TeamUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\Tenant.
 *
 * @method static Builder|Tenant newModelQuery()
 * @method static Builder|Tenant newQuery()
 * @method static Builder|Tenant query()
 * @property EloquentCollection<int, Model&UserContract> $members
 * @property int|null                                    $members_count
 * @property ProfileContract|null                        $creator
 * @property ProfileContract|null                        $updater
 * @property MediaCollection<int, Media>                 $media
 * @property int|null                                    $media_count
 * @property TenantUser                                  $pivot
 * @property EloquentCollection<int, User>               $users
 * @property int|null                                    $users_count
 * @mixin IdeHelperTenant
 * @property string               $id
 * @property string               $name
 * @property string|null          $slug
 * @property string|null          $domain
 * @property string|null          $database
 * @property int                  $is_active
 * @property Carbon|null          $created_at
 * @property Carbon|null          $updated_at
 * @property Carbon|null          $deleted_at
 * @property ProfileContract|null $deleter
 * @method static Builder<static>|Tenant whereCreatedAt($value)
 * @method static Builder<static>|Tenant whereDatabase($value)
 * @method static Builder<static>|Tenant whereDeletedAt($value)
 * @method static Builder<static>|Tenant whereDomain($value)
 * @method static Builder<static>|Tenant whereId($value)
 * @method static Builder<static>|Tenant whereIsActive($value)
 * @method static Builder<static>|Tenant whereName($value)
 * @method static Builder<static>|Tenant whereSlug($value)
 * @method static Builder<static>|Tenant whereUpdatedAt($value)
 * @property string|null $email_address
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $address
 * @property string|null $primary_color
 * @property string|null $secondary_color
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 * @property string|null $settings
 * @method static \Modules\User\Database\Factories\TenantFactory factory($count = null, $state = [])
 * @method static Builder<static>|Tenant whereAddress($value)
 * @method static Builder<static>|Tenant whereCreatedBy($value)
 * @method static Builder<static>|Tenant whereDeletedBy($value)
 * @method static Builder<static>|Tenant whereEmailAddress($value)
 * @method static Builder<static>|Tenant whereMobile($value)
 * @method static Builder<static>|Tenant wherePhone($value)
 * @method static Builder<static>|Tenant wherePrimaryColor($value)
 * @method static Builder<static>|Tenant whereSecondaryColor($value)
 * @method static Builder<static>|Tenant whereSettings($value)
 * @method static Builder<static>|Tenant whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class Tenant extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Modules\User\Models\TenantUser.
 *
 * @method static Builder|TeamUser newModelQuery()
 * @method static Builder|TeamUser newQuery()
 * @method static Builder|TeamUser query()
 * @property int         $id
 * @property string|null $tenant_id
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @method static Builder|TeamUser whereCreatedAt($value)
 * @method static Builder|TeamUser whereCreatedBy($value)
 * @method static Builder|TeamUser whereCustomerId($value)
 * @method static Builder|TeamUser whereId($value)
 * @method static Builder|TeamUser whereRole($value)
 * @method static Builder|TeamUser whereTeamId($value)
 * @method static Builder|TeamUser whereUpdatedAt($value)
 * @method static Builder|TeamUser whereUpdatedBy($value)
 * @method static Builder|TeamUser whereUserId($value)
 * @method static Builder|TeamUser whereUuid($value)
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder|TenantUser whereDeletedAt($value)
 * @method static Builder|TenantUser whereDeletedBy($value)
 * @method static Builder|TenantUser whereTenantId($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $deleter
 * @property ProfileContract|null $updater
 * @method static \Modules\User\Database\Factories\TenantUserFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	class TenantUser extends \Eloquent {}
}

namespace Modules\User\Models{
/**
 * Class Modules\User\Models\User.
 *
 * @property string                                            $id
 * @property string|null                                       $name
 * @property string|null                                       $first_name
 * @property string|null                                       $last_name
 * @property string                                            $email
 * @property Carbon|null                                       $email_verified_at
 * @property string                                            $password
 * @property string|null                                       $remember_token
 * @property int|null                                          $current_team_id
 * @property string|null                                       $profile_photo_path
 * @property Carbon|null                                       $created_at
 * @property Carbon|null                                       $updated_at
 * @property Carbon|null                                       $deleted_at
 * @property Carbon|null                                       $password_expires_at
 * @property string|null                                       $lang
 * @property bool                                              $is_active
 * @property bool                                              $is_otp
 * @property string|null                                       $updated_by
 * @property string|null                                       $created_by
 * @property string|null                                       $deleted_by
 * @property Collection<int, AuthenticationLog>                $authentications
 * @property int|null                                          $authentications_count
 * @property Collection<int, OauthClient>                      $clients
 * @property int|null                                          $clients_count
 * @property TenantUser                                        $pivot
 * @property Collection<int, Device>                           $devices
 * @property int|null                                          $devices_count
 * @property string|null                                       $full_name
 * @property AuthenticationLog|null                            $latestAuthentication
 * @property DatabaseNotificationCollection<int, Notification> $notifications
 * @property int|null                                          $notifications_count
 * @property Collection<int, Team>                             $ownedTeams
 * @property int|null                                          $owned_teams_count
 * @property Collection<int, Permission>                       $permissions
 * @property int|null                                          $permissions_count
 * @property ProfileContract|null                              $profile
 * @property Collection<int, Role>                             $roles
 * @property int|null                                          $roles_count
 * @property Membership                                        $membership
 * @property Collection<int, Team>                             $teams
 * @property int|null                                          $teams_count
 * @property Collection<int, Tenant>                           $tenants
 * @property int|null                                          $tenants_count
 * @property Collection<int, OauthAccessToken>                 $tokens
 * @property int|null                                          $tokens_count
 * @method static Builder|User         newModelQuery()
 * @method static Builder|User         newQuery()
 * @method static Builder|User         permission($permissions, $without = false)
 * @method static Builder|User         query()
 * @method static Builder|User         role($roles, $guard = null, $without = false)
 * @method static Builder|User         whereCreatedAt($value)
 * @method static Builder|User         whereCreatedBy($value)
 * @method static Builder|User         whereCurrentTeamId($value)
 * @method static Builder|User         whereDeletedAt($value)
 * @method static Builder|User         whereDeletedBy($value)
 * @method static Builder|User         whereEmail($value)
 * @method static Builder|User         whereEmailVerifiedAt($value)
 * @method static Builder|User         whereFirstName($value)
 * @method static Builder|User         whereId($value)
 * @method static Builder|User         whereIsActive($value)
 * @method static Builder|User         whereLang($value)
 * @method static Builder|User         whereLastName($value)
 * @method static Builder|User         whereName($value)
 * @method static Builder<static>|User whereNotNull($column, $boolean = 'and')
 * @method static Builder|User         wherePassword($value)
 * @method static Builder|User         whereProfilePhotoPath($value)
 * @method static Builder|User         whereRememberToken($value)
 * @method static Builder|User         whereUpdatedAt($value)
 * @method static Builder|User         whereUpdatedBy($value)
 * @method static Builder|User         withoutPermission($permissions)
 * @method static Builder|User         withoutRole($roles, $guard = null)
 * @property string                         $last_name
 * @property Team|null                      $currentTeam
 * @property MediaCollection<int, Media>    $media
 * @property int|null                       $media_count
 * @property Collection<int, SocialiteUser> $socialiteUsers
 * @property int|null                       $socialite_users_count
 * @property Collection<int, Membership>    $teamUsers
 * @property int|null                       $team_users_count
 * @property Collection<int, User>          $all_team_users
 * @property string|null                    $phone
 * @property string|null                    $address
 * @property string|null                    $city
 * @property string|null                    $registration_number
 * @property string|null                    $status
 * @property string|null                    $state
 * @property string|null                    $moderation_data
 * @property string|null                    $certifications
 * @property string|null                    $type
 * @method static Builder<static>|User whereAddress($value)
 * @method static Builder<static>|User whereCertifications($value)
 * @method static Builder<static>|User whereCity($value)
 * @method static Builder<static>|User whereIsOtp($value)
 * @method static Builder<static>|User whereModerationData($value)
 * @method static Builder<static>|User wherePasswordExpiresAt($value)
 * @method static Builder<static>|User wherePhone($value)
 * @method static Builder<static>|User whereRegistrationNumber($value)
 * @method static Builder<static>|User whereState($value)
 * @method static Builder<static>|User whereStatus($value)
 * @method static Builder<static>|User whereType($value)
 * @mixin IdeHelperUser
 * @property string|null $facebook_id
 * @method static Builder<static>|User whereFacebookId($value)
 * @property User|null $creator
 * @property User|null $updater
 * @property User|null $user
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property-read Collection<int, \Modules\User\Models\OauthClient> $oauthApps
 * @property-read int|null $oauth_apps_count
 * @method static Builder<static>|User childrenWith(array $relations)
 * @method static Builder<static>|User childrenWithCount(array $relations)
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static Builder<static>|User whereTwoFactorSecret($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Cache.
 *
 * @property string $key
 * @property string $value
 * @property int $expiration
 * @method static CacheFactory factory($count = null, $state = [])
 * @method static Builder<static>|Cache newModelQuery()
 * @method static Builder<static>|Cache newQuery()
 * @method static Builder<static>|Cache query()
 * @method static Builder<static>|Cache whereExpiration($value)
 * @method static Builder<static>|Cache whereKey($value)
 * @method static Builder<static>|Cache whereValue($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Cache extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\CacheLock.
 *
 * @property string $key
 * @property string $owner
 * @property int $expiration
 * @method static CacheLockFactory factory($count = null, $state = [])
 * @method static Builder<static>|CacheLock newModelQuery()
 * @method static Builder<static>|CacheLock newQuery()
 * @method static Builder<static>|CacheLock query()
 * @method static Builder<static>|CacheLock whereExpiration($value)
 * @method static Builder<static>|CacheLock whereKey($value)
 * @method static Builder<static>|CacheLock whereOwner($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class CacheLock extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Model Extra.
 *
 * @property string $id
 * @property string $model_type
 * @property string $model_id
 * @property SchemalessAttributes|null $extra_attributes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @method static ExtraFactory factory($count = null, $state = [])
 * @method static Builder<static>|Extra newModelQuery()
 * @method static Builder<static>|Extra newQuery()
 * @method static Builder<static>|Extra query()
 * @method static Builder<static>|Extra whereCreatedAt($value)
 * @method static Builder<static>|Extra whereCreatedBy($value)
 * @method static Builder<static>|Extra whereDeletedAt($value)
 * @method static Builder<static>|Extra whereDeletedBy($value)
 * @method static Builder<static>|Extra whereExtraAttributes($value)
 * @method static Builder<static>|Extra whereId($value)
 * @method static Builder<static>|Extra whereModelId($value)
 * @method static Builder<static>|Extra whereModelType($value)
 * @method static Builder<static>|Extra whereUpdatedAt($value)
 * @method static Builder<static>|Extra whereUpdatedBy($value)
 * @method static Builder<static>|Extra withExtraAttributes()
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @mixin \Eloquent
 */
	final class Extra extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Feed.
 *
 * @property string $id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static FeedFactory factory($count = null, $state = [])
 * @method static Builder<static>|Feed newModelQuery()
 * @method static Builder<static>|Feed newQuery()
 * @method static Builder<static>|Feed query()
 * @method static Builder<static>|Feed whereCreatedAt($value)
 * @method static Builder<static>|Feed whereCreatedBy($value)
 * @method static Builder<static>|Feed whereId($value)
 * @method static Builder<static>|Feed whereUpdatedAt($value)
 * @method static Builder<static>|Feed whereUpdatedBy($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Feed extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property int $id
 * @property string $check_name
 * @property string $check_label
 * @property string $status
 * @property string|null $notification_message
 * @property string|null $short_summary
 * @property array<array-key, mixed> $meta
 * @property string $ended_at
 * @property string $batch
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder<static>|HealthCheckResultHistoryItem newModelQuery()
 * @method static Builder<static>|HealthCheckResultHistoryItem newQuery()
 * @method static Builder<static>|HealthCheckResultHistoryItem query()
 * @method static Builder<static>|HealthCheckResultHistoryItem whereBatch($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereCheckLabel($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereCheckName($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereCreatedAt($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereCreatedBy($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereEndedAt($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereId($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereMeta($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereNotificationMessage($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereShortSummary($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereStatus($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereUpdatedAt($value)
 * @method static Builder<static>|HealthCheckResultHistoryItem whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class HealthCheckResultHistoryItem extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property int|null $table_rows
 * @property string $table_schema
 * @property string $table_name
 * @property string|null $model_class
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property int $id
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @method static InformationSchemaTableFactory factory($count = null, $state = [])
 * @method static Builder<static>|InformationSchemaTable newModelQuery()
 * @method static Builder<static>|InformationSchemaTable newQuery()
 * @method static Builder<static>|InformationSchemaTable query()
 * @method static Builder<static>|InformationSchemaTable whereCreatedAt($value)
 * @method static Builder<static>|InformationSchemaTable whereCreatedBy($value)
 * @method static Builder<static>|InformationSchemaTable whereId($value)
 * @method static Builder<static>|InformationSchemaTable whereModelClass($value)
 * @method static Builder<static>|InformationSchemaTable whereTableName($value)
 * @method static Builder<static>|InformationSchemaTable whereTableRows($value)
 * @method static Builder<static>|InformationSchemaTable whereTableSchema($value)
 * @method static Builder<static>|InformationSchemaTable whereUpdatedAt($value)
 * @method static Builder<static>|InformationSchemaTable whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	class InformationSchemaTable extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Feed.
 *
 * @property string|null $id
 * @property string|null $name
 * @property int|null $size
 * @method static LogFactory factory($count = null, $state = [])
 * @method static Builder<static>|Log newModelQuery()
 * @method static Builder<static>|Log newQuery()
 * @method static Builder<static>|Log query()
 * @method static Builder<static>|Log whereId($value)
 * @method static Builder<static>|Log whereName($value)
 * @method static Builder<static>|Log whereSize($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read string|null $file_content
 * @property-read ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class Log extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property bool|null $status
 * @property int|null $priority
 * @property string|null $path
 * @property string|null $icon
 * @property array<array-key, mixed>|null $colors
 * @method static Builder<static>|Module newModelQuery()
 * @method static Builder<static>|Module newQuery()
 * @method static Builder<static>|Module query()
 * @method static Builder<static>|Module whereColors($value)
 * @method static Builder<static>|Module whereDescription($value)
 * @method static Builder<static>|Module whereIcon($value)
 * @method static Builder<static>|Module whereId($value)
 * @method static Builder<static>|Module whereName($value)
 * @method static Builder<static>|Module wherePath($value)
 * @method static Builder<static>|Module wherePriority($value)
 * @method static Builder<static>|Module whereStatus($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @method static ModuleFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
	final class Module extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property string $id
 * @property int $bucket
 * @property int $period
 * @property string $type
 * @property string $key
 * @property string|null $key_hash
 * @property string $aggregate
 * @property string $value
 * @property int|null $count
 * @method static PulseAggregateFactory factory($count = null, $state = [])
 * @method static Builder<static>|PulseAggregate newModelQuery()
 * @method static Builder<static>|PulseAggregate newQuery()
 * @method static Builder<static>|PulseAggregate query()
 * @method static Builder<static>|PulseAggregate whereAggregate($value)
 * @method static Builder<static>|PulseAggregate whereBucket($value)
 * @method static Builder<static>|PulseAggregate whereCount($value)
 * @method static Builder<static>|PulseAggregate whereId($value)
 * @method static Builder<static>|PulseAggregate whereKey($value)
 * @method static Builder<static>|PulseAggregate whereKeyHash($value)
 * @method static Builder<static>|PulseAggregate wherePeriod($value)
 * @method static Builder<static>|PulseAggregate whereType($value)
 * @method static Builder<static>|PulseAggregate whereValue($value)
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $deleter
 * @property-read ProfileContract|null $updater
 * @mixin \Eloquent
 */
	class PulseAggregate extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property string $id
 * @property int $timestamp
 * @property string $type
 * @property string $key
 * @property string|null $key_hash
 * @property int|null $value
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static PulseEntryFactory factory($count = null, $state = [])
 * @method static Builder<static>|PulseEntry newModelQuery()
 * @method static Builder<static>|PulseEntry newQuery()
 * @method static Builder<static>|PulseEntry query()
 * @method static Builder<static>|PulseEntry whereId($value)
 * @method static Builder<static>|PulseEntry whereKey($value)
 * @method static Builder<static>|PulseEntry whereKeyHash($value)
 * @method static Builder<static>|PulseEntry whereTimestamp($value)
 * @method static Builder<static>|PulseEntry whereType($value)
 * @method static Builder<static>|PulseEntry whereValue($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class PulseEntry extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * @property string $id
 * @property int $timestamp
 * @property string $type
 * @property string $key
 * @property string|null $key_hash
 * @property string $value
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static PulseValueFactory factory($count = null, $state = [])
 * @method static Builder<static>|PulseValue newModelQuery()
 * @method static Builder<static>|PulseValue newQuery()
 * @method static Builder<static>|PulseValue query()
 * @method static Builder<static>|PulseValue whereId($value)
 * @method static Builder<static>|PulseValue whereKey($value)
 * @method static Builder<static>|PulseValue whereKeyHash($value)
 * @method static Builder<static>|PulseValue whereTimestamp($value)
 * @method static Builder<static>|PulseValue whereType($value)
 * @method static Builder<static>|PulseValue whereValue($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class PulseValue extends \Eloquent {}
}

namespace Modules\Xot\Models{
/**
 * Modules\Xot\Models\Session.
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $payload
 * @property int $last_activity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @method static SessionFactory factory($count = null, $state = [])
 * @method static Builder<static>|Session newModelQuery()
 * @method static Builder<static>|Session newQuery()
 * @method static Builder<static>|Session query()
 * @method static Builder<static>|Session whereCreatedAt($value)
 * @method static Builder<static>|Session whereCreatedBy($value)
 * @method static Builder<static>|Session whereDeletedAt($value)
 * @method static Builder<static>|Session whereDeletedBy($value)
 * @method static Builder<static>|Session whereId($value)
 * @method static Builder<static>|Session whereIpAddress($value)
 * @method static Builder<static>|Session whereLastActivity($value)
 * @method static Builder<static>|Session wherePayload($value)
 * @method static Builder<static>|Session whereUpdatedAt($value)
 * @method static Builder<static>|Session whereUpdatedBy($value)
 * @method static Builder<static>|Session whereUserAgent($value)
 * @method static Builder<static>|Session whereUserId($value)
 * @property-read ProfileContract|null $deleter
 * @mixin \Eloquent
 */
	class Session extends \Eloquent {}
}

