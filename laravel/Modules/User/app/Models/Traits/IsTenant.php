<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Contracts\TeamContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Undocumented trait.
 *
 * @property TeamContract $currentTeam
 */
trait IsTenant
{
    /**
     * Get all users associated with this tenant.
     *
     * @return BelongsToMany<Model&UserContract, static>
     */
    public function users(): BelongsToMany
    {
        $xot = XotData::make();
        $userClass = $xot->getUserClass();

        // $this->setConnection('mysql');
        /* @var class-string<Model&UserContract> $userClass */
        return $this->belongsToManyX($userClass, null, 'tenant_id', 'user_id');

        // ->as('membership')
    }
}
