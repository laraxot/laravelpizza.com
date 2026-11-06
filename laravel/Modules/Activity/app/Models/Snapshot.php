<?php

declare(strict_types=1);

namespace Modules\Activity\Models;

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
 *
 */
class Snapshot extends SpatieSnapshot
{
    /** > */
    use HasXotFactory;

    /** @laravel/Modules/UI/docs/bugfix-awstest-undefined-variable.md string */
    protected $connection = 'activity';

    protected $table = 'snapshots';

    /**
     * @return string|null
     */
    public function getConnectionName()
    {
        if (app()->environment('testing')) {
            $default = config('database.default');

            return is_string($default) ? $default : 'mysql';
        }

        return $this->connection instanceof \UnitEnum ? $this->connection->name : $this->connection;
    }

    /** @var list<string> */
    protected $fillable = ['id', 'aggregate_uuid', 'aggregate_version', 'state', 'created_at', 'updated_at'];
}
