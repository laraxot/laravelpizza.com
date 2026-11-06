<?php

declare(strict_types=1);
/**
 * ---.
 */

namespace Modules\Media\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Traits\MediaConvertMutator;
use Modules\Media\Models\Traits\MediaConvertRelationship;
use Modules\Xot\Contracts\ProfileContract;

/**
 * @property-read ProfileContract|null $creator
 * @property-read string|null $converted_file
 * @property-read string|null $disk
 * @property-read string|null $file
 * @property string|null $format
 * @property-read Media|null $media
 * @property-read ProfileContract|null $updater
 *
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> query()
 *
 * @property string $id
 * @property int $media_id
 * @property string|null $codec_video
 * @property string|null $codec_audio
 * @property string|null $preset
 * @property string|null $bitrate
 * @property int|null $width
 * @property int|null $height
 * @property int|null $threads
 * @property int|null $speed
 * @property string|null $percentage
 * @property string|null $remaining
 * @property string|null $rate
 * @property string|null $execution_time
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static> whereBitrate($value)
 * @method static Builder<static> whereCodecAudio($value)
 * @method static Builder<static> whereCodecVideo($value)
 * @method static Builder<static> whereCreatedAt($value)
 * @method static Builder<static> whereCreatedBy($value)
 * @method static Builder<static> whereDeletedAt($value)
 * @method static Builder<static> whereDeletedBy($value)
 * @method static Builder<static> whereExecutionTime($value)
 * @method static Builder<static> whereFormat($value)
 * @method static Builder<static> whereHeight($value)
 * @method static Builder<static> whereId($value)
 * @method static Builder<static> whereMediaId($value)
 * @method static Builder<static> wherePercentage($value)
 * @method static Builder<static> wherePreset($value)
 * @method static Builder<static> whereRate($value)
 * @method static Builder<static> whereRemaining($value)
 * @method static Builder<static> whereSpeed($value)
 * @method static Builder<static> whereThreads($value)
 * @method static Builder<static> whereUpdatedAt($value)
 * @method static Builder<static> whereUpdatedBy($value)
 * @method static Builder<static> whereWidth($value)
 */
class MediaConvert extends BaseModel
{
    use MediaConvertMutator;
    use MediaConvertRelationship;

    /** @var list<string> */
    protected $fillable = [
        'media_id',
        'format',
        'codec_video',
        'codec_audio',
        'preset',
        'bitrate',
        'width',
        'height',
        'threads',
        'speed',
        'percentage',
        'remaining',
        'rate',
        'execution_time',
    ];
}
