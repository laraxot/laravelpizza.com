<?php

declare(strict_types=1);

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Traits\MediaMutator;
use Modules\Media\Models\Traits\MediaRelationship;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

/**
 * @property-read ProfileContract|null $creator
 * @property-read string $extension
 * @property-read array<int, array{name: string, generated: bool, src: string}> $entry_conversions
 * @property-read string $path
 * @property-read string $human_readable_size
 * @property-read EloquentCollection<int, MediaConvert> $mediaConverts
 * @property-read int|null $media_converts_count
 * @property-read Model $model
 * @property-read string $original_url
 * @property-read string $preview_url
 * @property-read TemporaryUpload|null $temporaryUpload
 * @property-read string $type
 * @property-read ProfileContract|null $updater
 *
 * @method static MediaCollection<int, static> all($columns = ['*'])
 * @method static \Modules\Media\Database\Factories\MediaFactory factory($count = null, $state = [])
 * @method static MediaCollection<int, static> get($columns = ['*'])
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> ordered()
 * @method static Builder<static> query()
 *
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array<string, mixed>|null $manipulations
 * @property array<string, mixed>|null $custom_properties
 * @property array<string, bool>|null $generated_conversions
 * @property array<string, string>|null $responsive_images
 * @property int|null $order_column
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property int|null $user_id
 * @property string $directory
 * @property string|null $path
 * @property int|null $width
 * @property int|null $height
 * @property string|null $type
 * @property string|null $ext
 * @property string|null $alt
 * @property string|null $title
 * @property string|null $description
 * @property string|null $caption
 * @property string|null $exif
 * @property string|null $curations
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property ProfileContract|null $creator
 * @property Model $model
 * @property TemporaryUpload|null $temporaryUpload
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 * @property array<int, array{name: string, generated: bool, src: string}> $entry_conversions
 * @property EloquentCollection<int, MediaConvert> $mediaConverts
 * @property int|null $media_converts_count
 *
 * @method static Builder<static> whereCollectionName($value)
 * @method static Builder<static> whereConversionsDisk($value)
 * @method static Builder<static> whereCreatedAt($value)
 * @method static Builder<static> whereCreatedBy($value)
 * @method static Builder<static> whereCustomProperties($value)
 * @method static Builder<static> whereDeletedAt($value)
 * @method static Builder<static> whereDeletedBy($value)
 * @method static Builder<static> whereDisk($value)
 * @method static Builder<static> whereFileName($value)
 * @method static Builder<static> whereGeneratedConversions($value)
 * @method static Builder<static> whereId($value)
 * @method static Builder<static> whereManipulations($value)
 * @method static Builder<static> whereMimeType($value)
 * @method static Builder<static> whereModelId($value)
 * @method static Builder<static> whereModelType($value)
 * @method static Builder<static> whereName($value)
 * @method static Builder<static> whereOrderColumn($value)
 * @method static Builder<static> whereResponsiveImages($value)
 * @method static Builder<static> whereSize($value)
 * @method static Builder<static> whereUpdatedAt($value)
 * @method static Builder<static> whereUpdatedBy($value)
 * @method static Builder<static> whereUuid($value)
 */
class Media extends SpatieMedia
{
    use HasXotFactory;
    use MediaMutator;
    use MediaRelationship;
    use Updater {
        MediaRelationship::creator insteadof Updater;
    }

    /** @var string */
    protected $connection = 'media';

    /**
     * @param  array<int, string>  $uuids
     * @return MediaCollection<int, Media>
     */
    public static function findWithTemporaryUploadInCurrentSession(array $uuids): MediaCollection
    {
        $query = static::query();
        $query->whereIn('uuid', $uuids);
        $query->whereHasMorph('model', [TemporaryUpload::class], static fn (Builder $builder) => $builder->where(
            'session_id',
            session()->getId(),
        ));

        /** @var list<Media> $media */
        $media = array_values($query->get()->all());

        return new MediaCollection($media);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'manipulations' => 'array',
            'custom_properties' => 'array',
            'generated_conversions' => 'array',
            'responsive_images' => 'array',
        ];
    }
}
