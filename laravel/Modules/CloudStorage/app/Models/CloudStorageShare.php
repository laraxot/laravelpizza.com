<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Models;

/**
 * CloudStorageShare Model.
 *
 * Represents file/folder sharing permissions and links.
 */
class CloudStorageShare extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'file_id',
        'folder_id',
        'shared_by_user_id',
        'shared_with_user_id',
        'share_token',
        'share_link',
        'permission_level',
        'is_public',
        'is_password_protected',
        'password_hash',
        'expires_at',
        'access_count',
        'last_accessed_at',
        'max_downloads',
        'download_count',
        'status',
        'settings',
        'metadata',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'file_id' => 'integer',
            'folder_id' => 'integer',
            'shared_by_user_id' => 'integer',
            'shared_with_user_id' => 'integer',
            'is_public' => 'boolean',
            'is_password_protected' => 'boolean',
            'expires_at' => 'datetime',
            'access_count' => 'integer',
            'last_accessed_at' => 'datetime',
            'max_downloads' => 'integer',
            'download_count' => 'integer',
            'settings' => 'array',
            'metadata' => 'array',
        ]);
    }
}
