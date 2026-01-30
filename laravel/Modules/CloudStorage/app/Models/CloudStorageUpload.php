<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Models;

/**
 * CloudStorageUpload Model.
 *
 * Represents file upload sessions and chunked upload tracking.
 */
class CloudStorageUpload extends BaseModel
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'file_name',
        'original_name',
        'mime_type',
        'size',
        'total_chunks',
        'uploaded_chunks',
        'chunk_size',
        'upload_token',
        'upload_path',
        'temp_path',
        'final_path',
        'provider',
        'status',
        'progress_percentage',
        'started_at',
        'completed_at',
        'failed_at',
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
            'user_id' => 'integer',
            'size' => 'integer',
            'total_chunks' => 'integer',
            'uploaded_chunks' => 'integer',
            'chunk_size' => 'integer',
            'progress_percentage' => 'float',
            'retry_count' => 'integer',
            'max_retries' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'failed_at' => 'datetime',
            'settings' => 'array',
            'metadata' => 'array',
        ]);
    }
}
