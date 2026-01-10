<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\User\Database\Factories\MembershipFactory;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;

/**
 * Modules\User\Models\Membership.
 *
 * @property string $role
 *
 * @method static Builder|Membership newModelQuery()
 * @method static Builder|Membership newQuery()
 * @method static Builder|Membership query()
 *
 * @property int         $id
 * @property string|null $team_id
 * @property string|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $customer_id
 *
 * @method static Builder|Membership whereCreatedAt($value)
 * @method static Builder|Membership whereCreatedBy($value)
 * @method static Builder|Membership whereCustomerId($value)
 * @method static Builder|Membership whereRole($value)
 * @method static Builder|Membership whereTeamId($value)
 * @method static Builder|Membership whereUpdatedAt($value)
 * @method static Builder|Membership whereUpdatedBy($value)
 * @method static Builder|Membership whereUserId($value)
 *
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder|Membership whereDeletedAt($value)
 * @method static Builder|Membership whereDeletedBy($value)
 *
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 *
 * @mixin IdeHelperMembership
 *
 * @property ProfileContract|null $deleter
 *
 * @method static MembershipFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Membership whereId($value)
 *
 * @mixin \Eloquent
 */
class Membership extends BasePivot
{
    use HasXotFactory;

    /** @var string */
    protected $connection = 'user';

    /** @var string */
    protected $table = 'team_user';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'int';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'permissions' => 'array',
        ];
    }
}
