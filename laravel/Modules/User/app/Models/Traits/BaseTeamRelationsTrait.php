<?php

declare(strict_types=1);

namespace Modules\User\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\User\Models\TeamInvitation;
use Modules\User\Models\TeamUser;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Eloquent relationships for BaseTeam.
 */
trait BaseTeamRelationsTrait
{
    /**
     * @return BelongsTo<Model&UserContract, Model>
     */
    #[\Override]
    public function owner(): BelongsTo
    {
        $xotData = XotData::make();
        /** @var class-string<Model> */
        $user_class = $xotData->getUserClass();

        /** @var BelongsTo<Model&UserContract, Model> $relation */
        $relation = $this->belongsTo($user_class, 'user_id');

        return $relation;
    }

    /**
     * @return BelongsToMany<Model&UserContract, Model, TeamUser, 'pivot'>
     */
    #[\Override]
    public function users(): BelongsToMany
    {
        $xotData = XotData::make();
        /** @var class-string<Model> */
        $userClass = $xotData->getUserClass();

        /** @var BelongsToMany<Model&UserContract, Model, TeamUser, 'pivot'> $relation */
        $relation = $this->belongsToManyX($userClass)
            ->using(TeamUser::class)
            ->withPivot(['role', 'permissions']);

        return $relation;
    }

    /**
     * Get the team users (memberships) relationship.
     *
     * @return HasMany<TeamUser, $this>
     */
    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

    /**
     * @return BelongsToMany<Model&UserContract, Model, TeamUser, 'pivot'>
     */
    #[\Override]
    public function members(): BelongsToMany
    {
        return $this->users();
    }

    /**
     * @return HasMany<TeamInvitation, Model>
     */
    #[\Override]
    public function teamInvitations(): HasMany
    {
        /** @var HasMany<TeamInvitation, Model> $relation */
        $relation = $this->hasMany(TeamInvitation::class);

        return $relation;
    }
}
