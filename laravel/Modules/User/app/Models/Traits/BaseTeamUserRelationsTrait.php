<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Team;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Eloquent relationships for BaseTeamUser.
 */
trait BaseTeamUserRelationsTrait
{
    /**
     * Relazione con User.
     *
     * @return BelongsTo<Model&UserContract, $this>
     */
    public function user(): BelongsTo
    {
        $userClass = XotData::make()->getUserClass();

        /* @var BelongsTo<Model&UserContract, $this> */
        return $this->belongsTo($userClass);
    }

    /**
     * Relazione con Team.
     *
     * @return BelongsTo<Model&TeamContract, $this>
     */
    public function team(): BelongsTo
    {
        $teamClass = XotData::make()->getTeamClass();

        /* @var BelongsTo<Model&TeamContract, $this> */
        return $this->belongsTo($teamClass);
    }
}
