<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Activity\Traits\ActivityScopes;
use Modules\Xot\Models\Traits\HasXotFactory;
use Spatie\Activitylog\Models\Activity as SpatieActivity;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

/**
 * Class Activity.
 *
 * Modello audit log del modulo: estende Spatie Activitylog sulla connessione `activity`.
 * Scopo: tracciare eventi (created/updated/deleted/login/…) con subject, causer e properties.
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
 * @mixin \Eloquent
 */
class Activity extends SpatieActivity
{
    use ActivityScopes;
    use HasXotFactory;

    /** @var string */
    protected $connection = 'activity';

    protected $table = 'activity_log';

    /**
     * Entry point tipizzato per le Action del modulo (evita builder troppo larghi di Spatie).
     *
     * @return Builder<Activity>
     */
    public static function typedQuery(): Builder
    {
        return (new self)->newQuery();
    }

    /**
     * @param  Builder<Activity>|QueryBuilder  $query
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
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'properties' => SchemalessAttributes::class,
            'attribute_changes' => 'collection',
        ];
    }
}
