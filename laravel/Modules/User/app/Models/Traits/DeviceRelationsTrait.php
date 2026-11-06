<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Eloquent relationships for Device.
 */
trait DeviceRelationsTrait
{
    /**
     * @return BelongsToMany<Model&UserContract, $this, Pivot, 'pivot'>
     */
    public function users(): BelongsToMany
    {
        $userClass = XotData::make()->getUserClass();

        /** @var BelongsToMany<Model&UserContract, $this, Pivot, 'pivot'> $relation */
        $relation = $this->belongsToManyX($userClass);

        return $relation;
    }
}
