<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Modules\User\Contracts\TeamInvitationContract.
 *
 * @property int          $id
 * @property int          $team_id
 * @property string       $email
 * @property string|null  $role
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property TeamContract $team
 *
 * @method static Builder|TeamInvitationContract newModelQuery()
 * @method static Builder|TeamInvitationContract newQuery()
 * @method static Builder|TeamInvitationContract query()
 * @method static Builder|TeamInvitationContract whereCreatedAt($value)
 * @method static Builder|TeamInvitationContract whereEmail($value)
 * @method static Builder|TeamInvitationContract whereId($value)
 * @method static Builder|TeamInvitationContract whereRole($value)
 * @method static Builder|TeamInvitationContract whereTeamId($value)
 * @method static Builder|TeamInvitationContract whereUpdatedAt($value)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface TeamInvitationContract
{
    public function delete(): void;
}
