<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Models;

/**
 * CloudStorageProvider Model.
 *
 * Represents a cloud storage provider configuration.
 */
class CloudStorageProvider extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'provider_key',
        'api_key',
        'api_secret',
        'access_token',
        'refresh_token',
        'bucket_name',
        'region',
        'endpoint',
        'is_active',
        'is_default',
        'priority',
        'max_file_size',
        'max_storage_size',
        'used_storage_size',
        'file_count',
        'folder_count',
        'status',
        'last_sync_at',
        'last_error_at',
        'error_message',
        'retry_count',
        'max_retries',
        'settings',
        'metadata',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'priority' => 'integer',
            'max_file_size' => 'integer',
            'max_storage_size' => 'integer',
            'used_storage_size' => 'integer',
            'file_count' => 'integer',
            'folder_count' => 'integer',
            'retry_count' => 'integer',
            'max_retries' => 'integer',
            'last_sync_at' => 'datetime',
            'last_error_at' => 'datetime',
            'settings' => 'array',
            'metadata' => 'array',
        ]);
    }
}
