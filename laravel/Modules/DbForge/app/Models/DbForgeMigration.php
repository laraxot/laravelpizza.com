<?php

declare(strict_types=1);

namespace Modules\DbForge\Models;

/**
 * DbForgeMigration model.
 *
 * @property int $id
 * @property string $migration_name
 * @property string $migration_path
 * @property string $migration_type
 * @property string $status
 * @property string|null $batch
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $executed_at
 * @property array|null $metadata
 * @property array|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class DbForgeMigration extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dbforge_migrations';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'migration_name',
        'migration_path',
        'migration_type',
        'status',
        'batch',
        'created_by',
        'executed_at',
        'metadata',
        'settings',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_by' => 'integer',
            'executed_at' => 'datetime',
            'metadata' => 'array',
            'settings' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
