<?php

declare(strict_types=1);

namespace Modules\CloudStorage\Models;

use Modules\Xot\Datas\XotData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Modules\CloudStorage\Database\Factories\CloudStorageFileFactory;

/**
 * Cloud Storage File Model.
 *
 * Manages files stored in various cloud storage providers (Google Drive, Dropbox, AWS S3, etc.)
 * with comprehensive metadata, security features, and usage tracking.
 *
 * Business Logic:
 * - Multi-provider cloud storage abstraction
 * - File metadata and content type management
 * - Encryption and security features
 * - Usage analytics and access tracking
 * - File lifecycle management (upload, process, store, delete)
 *
 * @property int $id
 * @property string $name File display name
 * @property string $original_name Original filename when uploaded
 * @property string $mime_type File MIME type
 * @property int $size File size in bytes
 * @property string $path Local storage path
 * @property string $storage_path Cloud storage path
 * @property string $provider Cloud provider (google_drive, dropbox, aws_s3, etc.)
 * @property string|null $bucket Storage bucket/container name
 * @property string|null $region Storage region
 * @property string $status File status (pending, uploading, completed, failed, deleted)
 * @property bool $is_public Whether file is publicly accessible
 * @property bool $is_encrypted Whether file is encrypted
 * @property string|null $encryption_key Encryption key for encrypted files
 * @property string $checksum File integrity checksum
 * @property array<string, mixed> $metadata File metadata (dimensions, duration, etc.)
 * @property array<string, mixed> $settings File processing settings
 * @property int $user_id Owner user ID
 * @property int|null $folder_id Parent folder ID
 * @property Carbon|null $uploaded_at When file was uploaded
 * @property Carbon|null $last_accessed_at Last access timestamp
 * @property int $download_count Download counter
 * @property int $view_count View counter
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 *
 * @method static CloudStorageFileFactory factory($count = null, $state = [])
 * @method static Builder|CloudStorageFile newModelQuery()
 * @method static Builder|CloudStorageFile newQuery()
 * @method static Builder|CloudStorageFile query()
 * @method static Builder|CloudStorageFile whereStatus(string $status)
 * @method static Builder|CloudStorageFile whereProvider(string $provider)
 * @method static Builder|CloudStorageFile whereIsPublic(bool $isPublic)
 * @method static Builder|CloudStorageFile whereIsEncrypted(bool $isEncrypted)
 *
 * @mixin \Eloquent
 */
class CloudStorageFile extends BaseModel
{
    /** @var string */
    protected $table = 'cloud_storage_files';

    /** @var list<string> */
    protected $fillable = [
        'name',
        'original_name',
        'mime_type',
        'size',
        'path',
        'storage_path',
        'provider',
        'bucket',
        'region',
        'status',
        'is_public',
        'is_encrypted',
        'encryption_key',
        'checksum',
        'metadata',
        'settings',
        'user_id',
        'folder_id',
        'uploaded_at',
        'last_accessed_at',
        'download_count',
        'view_count',
    ];

    /** @var list<string> */
    protected $hidden = [
        'encryption_key',
    ];

    /**
     * Get the user that owns the file.
     */
    public function user(): BelongsTo
    {
        $userClass = XotData::make()->getUserClass();

        return $this->belongsTo($userClass);
    }

    /**
     * Get the folder that contains the file.
     *
     * @todo Implement CloudStorageFolder model
     */
    // public function folder(): BelongsTo
    // {
    //     return $this->belongsTo(CloudStorageFolder::class, 'folder_id');
    // }

    /**
     * Scope a query to only include files of a given status.
     */
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include files from a specific provider.
     */
    public function scopeProvider(Builder $query, string $provider): Builder
    {
        return $query->where('provider', $provider);
    }

    /**
     * Scope a query to only include public files.
     */
    public function scopePublic(Builder $query): Builder
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to only include private files.
     */
    public function scopePrivate(Builder $query): Builder
    {
        return $query->where('is_public', false);
    }

    /**
     * Scope a query to only include encrypted files.
     */
    public function scopeEncrypted(Builder $query): Builder
    {
        return $query->where('is_encrypted', true);
    }

    /**
     * Scope a query to only include completed files.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include recently accessed files.
     */
    public function scopeRecentlyAccessed(Builder $query, int $days = 30): Builder
    {
        return $query->where('last_accessed_at', '>=', now()->subDays($days));
    }

    /**
     * Get the file's human-readable size.
     */
    public function getHumanReadableSizeAttribute(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < \count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }

    /**
     * Get the file's extension from its name.
     */
    public function getExtensionAttribute(): string
    {
        return pathinfo($this->name, PATHINFO_EXTENSION);
    }

    /**
     * Check if the file is an image.
     */
    public function getIsImageAttribute(): bool
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Check if the file is a video.
     */
    public function getIsVideoAttribute(): bool
    {
        return str_starts_with($this->mime_type, 'video/');
    }

    /**
     * Check if the file is a document.
     */
    public function getIsDocumentAttribute(): bool
    {
        return \in_array($this->mime_type, [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        ], true);
    }

    /**
     * Mark the file as accessed and increment view count.
     */
    public function markAsAccessed(): void
    {
        $this->increment('view_count');
        $this->update(['last_accessed_at' => now()]);
    }

    /**
     * Increment download count.
     */
    public function incrementDownloads(): void
    {
        $this->increment('download_count');
    }

    /**
     * Check if file upload is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if file upload is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if file is currently uploading.
     */
    public function isUploading(): bool
    {
        return $this->status === 'uploading';
    }

    /**
     * Check if file upload failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Check if file is deleted.
     */
    public function isDeleted(): bool
    {
        return $this->status === 'deleted';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'size' => 'integer',
            'is_public' => 'boolean',
            'is_encrypted' => 'boolean',
            'metadata' => 'array',
            'settings' => 'array',
            'user_id' => 'integer',
            'folder_id' => 'integer',
            'download_count' => 'integer',
            'view_count' => 'integer',
            'uploaded_at' => 'datetime',
            'last_accessed_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
