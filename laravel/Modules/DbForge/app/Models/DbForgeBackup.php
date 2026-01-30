<?php

declare(strict_types=1);

namespace Modules\DbForge\Models;

/**
 * DbForgeBackup model.
 *
 * @property int $id
 * @property string $backup_name
 * @property string $backup_path
 * @property int $backup_size
 * @property string $backup_type
 * @property string $status
 * @property int $retention_days
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property array|null $metadata
 * @property array|null $settings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class DbForgeBackup extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dbforge_backups';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'backup_name',
        'backup_path',
        'backup_size',
        'backup_type',
        'status',
        'retention_days',
        'created_by',
        'completed_at',
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
            'backup_size' => 'integer',
            'retention_days' => 'integer',
            'created_by' => 'integer',
            'completed_at' => 'datetime',
            'metadata' => 'array',
            'settings' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
