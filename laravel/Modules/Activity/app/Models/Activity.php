<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Xot\Models\Traits\HasXotFactory;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

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
 *
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
 * @method static Builder<static>|Activity causedBy(\Illuminate\Database\Eloquent\Model $causer)
 *
 * @mixin \Eloquent
 */
class Activity extends SpatieActivity
{
    use HasXotFactory;

    protected $connection = 'activity';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type', // Added
        'causer_id',   // Added
        'properties', // Added
    ];

    // NOTE
    // ----
    // We intentionally do not override static query helper methods here
    // (query, whereDate, whereMonth, whereYear, whereBetween, selectRaw,
    // latest, limit, with, count, clone). The underlying
    // Spatie\Activitylog\Models\Activity base model already exposes the
    // appropriate fluent Eloquent API, and PHPStan understands these via
    // the @method annotations declared in this PHPDoc. Keeping only the
    // annotations avoids return.type conflicts while preserving behaviour.
}
