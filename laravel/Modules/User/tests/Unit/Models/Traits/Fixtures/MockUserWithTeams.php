<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Models\Traits\Fixtures;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
=======
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\User\Contracts\TeamContract;
use Modules\User\Models\Team;
use Modules\User\Models\TeamUser;
>>>>>>> 9fa499be (.)
use Modules\User\Models\Traits\HasTeams;

<<<<<<< HEAD
=======
/**
 * Stub model for HasTeams trait unit tests; satisfies PHPStan in-context analysis.
 *
 * @property string                            $id
 * @property int|null                          $current_team_id
 * @property TeamContract|null                 $currentTeam
 * @property EloquentCollection<int, Team>     $membershipTeams
 * @property EloquentCollection<int, Team>     $ownedTeams
 * @property EloquentCollection<int, TeamUser> $teamUsers
 * @property XotUserContract|null              $owner
 * @property int                               $total_members
 */
>>>>>>> 6d3760fe (.)
class MockUserWithTeams extends Model
{
    use HasTeams;

    protected $table = 'users';

    protected $fillable = ['name', 'email'];

    public function getKey(): int
    {
<<<<<<< HEAD
        return 1;
=======
        return (string) ($this->attributes['id'] ?? 'mock-user-1');
    }

    /**
     * @param string|int|Permission $permission
     */
    public function hasPermissionTo($permission, ?string $guardName = null): bool
    {
        return false;
    }

    /**
     * @param string|int|array|Role|\BackedEnum $roles
     */
    public function hasRole($roles, ?string $guard = null): bool
    {
        return false;
    }

    /**
     * @return BelongsToMany<Model&TeamContract, Model, Pivot, 'pivot'>
     */
    public function membershipTeams(): BelongsToMany
    {
<<<<<<< HEAD
        return $this->belongsToManyX(Team::class);
>>>>>>> 6d3760fe (.)
=======
        /** @var BelongsToMany<Model&TeamContract, Model, Pivot, 'pivot'> $relation */
        $relation = $this->belongsToManyX(Team::class);

        return $relation;
>>>>>>> 9fa499be (.)
    }
}
