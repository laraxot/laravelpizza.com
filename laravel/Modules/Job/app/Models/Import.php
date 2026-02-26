<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Job\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Job\Database\Factories\ImportFactory;
use Modules\Xot\Contracts\ProfileContract;
use Override;

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
class Import extends BaseModel
{
    protected $fillable = [
        'id',
        'completed_at',
        'file_name',
        'file_path',
        'importer',
        'processed_rows',
        'total_rows',
        'successful_rows',
        'user_id',
    ];

    #[Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'data' => 'json',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'payload' => 'array',
            'completed_at' => 'datetime',
            // 'updated_at' => 'datetime:Y-m-d H:00',
            // 'created_at' => 'datetime:Y-m-d',
            // 'created_at' => 'datetime:d/m/Y H:i'
        ];
    }
}
