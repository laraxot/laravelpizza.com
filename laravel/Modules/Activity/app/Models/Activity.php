<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Activity\Database\Factories\ActivityFactory;
use Modules\Activity\Traits\ActivityScopes;
use Modules\Xot\Models\Traits\HasXotFactory;
use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

/**
 * Class Activity.
 *
 * This class extends the BaseActivity model to represent activities in the application.
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property string|null $subject_id
 * @property string|null $causer_type
 * @property string|null $causer_id
 * @property array<string, mixed>|Collection<array-key, mixed>|null $properties
 * @property Collection<int, mixed>|null $attribute_changes
 * @property string|null $batch_uuid
 * @property string|null $event
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read Model|null $causer
 * @property-read Collection<int, mixed> $changes
 * @property-read Model|null $subject
 *
 * @method static ActivityFactory factory($count = null, $state = [])
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> query()
 * @method static static create(array<string, mixed> $attributes = [])
 */
class Activity extends SpatieActivity
{
    use ActivityScopes;

    /** > */
    use HasXotFactory;

    /** @var string */
    protected $connection = 'activity';

    protected $table = 'activity_log';

    /**
     * Typed query entry point for actions that operate on this concrete model.
     *
     * The upstream activity model exposes a broad builder type; this keeps the
     * module's action contracts tied to Activity without weakening them.
     *
     * @return Builder<Activity>
     */
    public static function typedQuery(): Builder
    {
        return (new self)->newQuery();
    }

    /**
     * @param Builder<Activity>|QueryBuilder $query
     * @return EloquentCollection<int, Activity>
     */
    public static function typedGet(Builder|QueryBuilder $query): EloquentCollection
    {
        $activities = [];
        foreach ($query->get() as $activity) {
            if ($activity instanceof self) {
                $activities[] = $activity;
            }
        }

        return new EloquentCollection($activities);
    }

    /** @var list<string> */
    protected $fillable = [
        'id',
        'log_name',
        'description',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'attribute_changes',
        'batch_uuid',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'properties' => SchemalessAttributes::class,
            'attribute_changes' => 'collection',
        ];
    }

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
