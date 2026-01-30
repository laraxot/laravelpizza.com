<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Models;

/**
 * CloudStorageQuota Model.
 *
 * Represents storage quota limits and usage tracking.
 */
class CloudStorageQuota extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'total_storage',
        'used_storage',
        'file_count',
        'folder_count',
        'max_file_size',
        'max_files',
        'is_unlimited',
        'warning_threshold',
        'quota_exceeded_at',
        'last_calculated_at',
        'settings',
        'metadata',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'user_id' => 'integer',
            'total_storage' => 'integer',
            'used_storage' => 'integer',
            'file_count' => 'integer',
            'folder_count' => 'integer',
            'max_file_size' => 'integer',
            'max_files' => 'integer',
            'is_unlimited' => 'boolean',
            'warning_threshold' => 'integer',
            'quota_exceeded_at' => 'datetime',
            'last_calculated_at' => 'datetime',
            'settings' => 'array',
            'metadata' => 'array',
        ]);
    }
}
