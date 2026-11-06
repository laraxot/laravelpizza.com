<?php

declare(strict_types=1);

namespace Modules\Media\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaConvert;

/**
 * Relazioni di {@see MediaConvert}.
 *
 * @phpstan-require-extends MediaConvert
 */
trait MediaConvertRelationship
{
    /**
     * @return BelongsTo<Media, $this>
     */
    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
