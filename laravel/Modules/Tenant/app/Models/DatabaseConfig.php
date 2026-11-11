<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Modules\Xot\Contracts\ProfileContract;

/**
 * @property-read ProfileContract|null $creator
 * @property-read ProfileContract|null $updater
 * @property-read ProfileContract|null $deleter
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DatabaseConfig query()
 */
class DatabaseConfig extends BaseModel
{
    protected $table = 'database_configs';

    protected $fillable = [
        'host',
        'port',
        'database',
        'username',
        'password',
        'charset',
        'collation',
        'prefix',
        'prefix_indexes',
        'strict',
        'engine',
        'options',
    ];

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'port' => 'integer',
            'prefix_indexes' => 'boolean',
            'strict' => 'boolean',
            'options' => 'array',
        ]);
    }
}
