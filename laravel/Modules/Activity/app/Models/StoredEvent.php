<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Modules\Xot\Models\Traits\HasXotFactory;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent as SpatieStoredEvent;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;
use Spatie\SchemalessAttributes\SchemalessAttributes;

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
 * @method static \Modules\Activity\Database\Factories\StoredEventFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class StoredEvent extends SpatieStoredEvent
{
    use HasXotFactory;

    /** @var string */
    protected $connection = 'activity';

    /** @var string */
    protected $table = 'stored_events';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'aggregate_uuid',
        'aggregate_version',
        'event_version',
        'event_class',
        'event_properties',
        'meta_data',
        'created_at',
        'updated_by',
        'created_by',
    ];
}
