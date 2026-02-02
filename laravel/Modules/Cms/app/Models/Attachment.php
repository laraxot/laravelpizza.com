<?php

declare(strict_types=1);

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Cms\Database\Factories\AttachmentFactory;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * ---.
 *
 * @property string                       $id
 * @property array<array-key, mixed>|null $title
 * @property array<array-key, mixed>|null $description
 * @property string|null                  $slug
 * @property string|null                  $disk
 * @property array<array-key, mixed>|null $attachment
 * @property Carbon|null                  $created_at
 * @property Carbon|null                  $updated_at
 * @property string|null                  $created_by
 * @property string|null                  $updated_by
 * @property ProfileContract|null         $creator
 * @property MediaCollection<int, Media>  $media
 * @property int|null                     $media_count
 * @property mixed                        $translations
 * @property ProfileContract|null         $updater
 *
 * @method static Builder<static>|Attachment newModelQuery()
 * @method static Builder<static>|Attachment newQuery()
 * @method static Builder<static>|Attachment query()
 * @method static Builder<static>|Attachment whereAttachment($value)
 * @method static Builder<static>|Attachment whereCreatedAt($value)
 * @method static Builder<static>|Attachment whereCreatedBy($value)
 * @method static Builder<static>|Attachment whereDescription($value)
 * @method static Builder<static>|Attachment whereDisk($value)
 * @method static Builder<static>|Attachment whereId($value)
 * @method static Builder<static>|Attachment whereJsonContainsLocale(string $column, string $locale, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Attachment whereJsonContainsLocales(string $column, array $locales, ?mixed $value, string $operand = '=')
 * @method static Builder<static>|Attachment whereLocale(string $column, string $locale)
 * @method static Builder<static>|Attachment whereLocales(string $column, array $locales)
 * @method static Builder<static>|Attachment whereSlug($value)
 * @method static Builder<static>|Attachment whereTitle($value)
 * @method static Builder<static>|Attachment whereUpdatedAt($value)
 * @method static Builder<static>|Attachment whereUpdatedBy($value)
 * @method static static|null                firstWhere(string $column, mixed $operator = null, mixed $value = null)
 *
 * @property ProfileContract|null $deleter
 *
 * @method static AttachmentFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Attachment extends BaseModelLang implements HasMedia
{
    use InteractsWithMedia;
    use SushiToJsons;

    /** @var array<int, string> */
    public $translatable = [
        'title',
        'description',
        'attachment',
    ];

    protected $fillable = [
        'title',
        'description',
        'slug',
        'disk',
        'attachment',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'description' => 'json',
        'slug' => 'string',
        'disk' => 'string',
        'attachment' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    /*
     * protected static function boot()
     * {
     * parent::boot();
     *
     * static::saving(function ($model) {
     * $currentLocale = app()->getLocale();
     * $attachment = $model->attachment ?? [];
     *
     * // If we have a file upload, process it
     * if (request()->hasFile('attachment')) {
     * $file = request()->file('attachment');
     * $uuid = (string) \Illuminate\Support\Str::uuid();
     * $fileName = $file->getClientOriginalName();
     * $path = $file->storeAs('attachments', $uuid . '_' . $fileName, 'public');
     *
     * // Initialize the attachment array for the current locale if it doesn't exist
     * if (!isset($attachment[$currentLocale])) {
     * $attachment[$currentLocale] = [];
     * }
     *
     * // Store the file information
     * $attachment[$currentLocale][$uuid] = $fileName;
     * $model->attachment = $attachment;
     * }
     * });
     * }
     */

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')->acceptsMimeTypes([
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/zip',
            'image/jpeg',
            'image/png',
            'image/gif',
            'image/svg+xml',
        ]);
    }

    public function getAttachmentForLocale(?string $locale = null): ?string
    {
        $locale ??= app()->getLocale();
        $media = $this->getFirstMedia('attachments');

        if ($media && $media->getCustomProperty('locale') === $locale) {
            return $media->getUrl();
        }

        return null;
    }

    public function asset(): string
    {
        // PHPStan L10: Check attachment is array before array_values
        if (! is_array($this->attachment)) {
            return '';
        }

        $values = array_values($this->attachment);
        if (empty($values)) {
            return '';
        }

        // PHPStan L10: Type narrowing for array offset access
        if (! isset($values[0])) {
            return '';
        }

        $file = $values[0];
        if (! is_string($file)) {
            return '';
        }

        $storage = Storage::disk($this->disk);
        if (! method_exists($storage, 'url')) {
            return '';
        }

        $url = $storage->url($file);

        return is_string($url) ? $url : '';
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @return array<string, string> */
    #[\Override]
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'disk' => 'string',
            'uuid' => 'string',
            'date' => 'datetime',
            'published_at' => 'datetime',
            'active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'attachment' => 'array',
        ];
    }
}
