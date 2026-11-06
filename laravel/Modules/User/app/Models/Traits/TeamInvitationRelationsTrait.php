<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Xot\Datas\XotData;

/**
 * Eloquent relationships for TeamInvitation.
 */
trait TeamInvitationRelationsTrait
{
    /**
     * @return BelongsTo<Model, $this>
     */
    public function team(): BelongsTo
    {
        $xotData = XotData::make();
        /** @var class-string<Model> */
        $team_class = $xotData->getTeamClass();

        return $this->belongsTo($team_class);
    }
}
