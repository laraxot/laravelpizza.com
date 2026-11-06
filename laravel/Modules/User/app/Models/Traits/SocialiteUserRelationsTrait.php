<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Datas\XotData;

/**
 * Eloquent relationships for SocialiteUser.
 */
trait SocialiteUserRelationsTrait
{
    /**
     * @return BelongsTo<Model, $this>
     */
    public function user(): BelongsTo
    {
        /** @var class-string<Model> */
        $user_class = XotData::make()->getUserClass();

        return $this->belongsTo($user_class);
    }
}
