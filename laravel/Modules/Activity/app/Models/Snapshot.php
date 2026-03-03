<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Activity\Database\Factories\SnapshotFactory;
use Modules\Xot\Models\Traits\HasXotFactory;
use Spatie\EventSourcing\Snapshots\EloquentSnapshot as SpatieSnapshot;

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
class Snapshot extends SpatieSnapshot
{
    use HasXotFactory;

    /** @var string */
    protected $connection = 'activity';

    protected $table = 'snapshots';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (app()->environment('testing')) {
            $this->connection = 'mysql';
        }
    }

    /** @var list<string> */
    protected $fillable = ['id', 'aggregate_uuid', 'aggregate_version', 'state', 'created_at', 'updated_at'];
}
