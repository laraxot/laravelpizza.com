<?php

declare(strict_types=1);

namespace Modules\Media\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaConvert;
use Modules\Media\Models\TemporaryUpload;
use Modules\Xot\Datas\XotData;

/**
 * Relazioni di {@see Media}.
 *
 * @phpstan-require-extends Media
 */
trait MediaRelationship
{
    /**
     * return BelongsTo<TemporaryUpload,self|$this>.
     *
     * @return BelongsTo<TemporaryUpload,covariant Media>
     */
    public function temporaryUpload(): BelongsTo
    {
        return $this->belongsTo(TemporaryUpload::class);
    }

    /**
     * Relazione con il creatore del media.
     *
     * @return BelongsTo<Model, self>
     *
     * @phpstan-return BelongsTo<Model, $this>
     */
    public function creator(): BelongsTo
    {
        /** @var class-string<Model> $userClass */
        $userClass = XotData::make()->getUserClass();

        return $this->belongsTo($userClass, 'created_by');
    }

    /**
     * @return HasMany<MediaConvert, $this>
     */
    public function mediaConverts(): HasMany
    {
        return $this->hasMany(MediaConvert::class);
    }
}
