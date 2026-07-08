<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\User\Contracts\TeamContract;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

/**
 * Modules\User\Models\Team.
 *
 * @property int                                         $id
 * @property int                                         $user_id
 * @property string                                      $name
 * @property int                                         $personal_team
 * @property Carbon|null                                 $created_at
 * @property Carbon|null                                 $updated_at
 * @property EloquentCollection<int, Model&UserContract> $members
 * @property int|null                                    $members_count
 * @property UserContract|null                           $owner
 * @property EloquentCollection<int, TeamInvitation>     $teamInvitations
 * @property int|null                                    $team_invitations_count
 * @property EloquentCollection<int, Model&UserContract> $users
 * @property int|null                                    $users_count
 *
 * @method static Builder|Team newModelQuery()
 * @method static Builder|Team newQuery()
 * @method static Builder|Team query()
 * @method static Builder|Team whereCreatedAt($value)
 * @method static Builder|Team whereId($value)
 * @method static Builder|Team whereName($value)
 * @method static Builder|Team wherePersonalTeam($value)
 * @method static Builder|Team whereUpdatedAt($value)
 * @method static Builder|Team whereUserId($value)
 *
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property Carbon|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder|Team whereCreatedBy($value)
 * @method static Builder|Team whereDeletedAt($value)
 * @method static Builder|Team whereDeletedBy($value)
 * @method static Builder|Team whereUpdatedBy($value)
 *
 * @property Membership           $membership
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property string               $uuid
 *
 * @method static Builder|Team whereUuid($value)
 *
 * @mixin \Eloquent
 */
abstract class BaseTeam extends BaseModel implements TeamContract
{
    // Se ho bisogno di extra in customer aggiungo extra in customer
    // use HasExtraTrait;

    /** @var list<string> */
    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'personal_team',
    ];

    /** @var list<string> */
    protected $with = [
        // 'extra',
    ];

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
     * Get all of the team's users including its owner.
     *
     * @return Collection<int, Model&UserContract>
     */
    #[\Override]
    public function allUsers(): Collection
    {
        if (! $this->owner instanceof User) {
            return $this->users;
        }

        return $this->users->merge([$this->owner]);
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
     * Determina se l'utente specificato appartiene al team.
     *
     * @param UserContract $user L'utente da verificare
     *
     * @return bool True se l'utente appartiene al team, false altrimenti
     */
    #[\Override]
    public function hasUser(UserContract $user): bool
    {
        // Corretto l'errore di tipo per il metodo contains
        // Verifico se l'ID dell'utente è presente nella collection degli utenti del team
        if ($this->users->contains('id', $user->getKey())) {
            return true;
        }

        return $user->ownsTeam($this);
    }

    /**
     * Determina se l'indirizzo email specificato appartiene a un utente del team.
     *
     * @param string $email Indirizzo email da verificare
     *
     * @return bool True se un utente con quell'email appartiene al team, false altrimenti
     */
    #[\Override]
    public function hasUserWithEmail(string $email): bool
    {
        return $this->allUsers()->contains(static function (Model&UserContract $user) use ($email): bool {
            return ($user->email ?? null) === $email;
        });
    }

    /**
     * Determina se l'utente specificato ha il permesso indicato sul team.
     *
     * @param UserContract $userContract L'utente da verificare
     * @param string       $permission   Il permesso da controllare
     *
     * @return bool True se l'utente ha il permesso, false altrimenti
     */
    #[\Override]
    public function userHasPermission(UserContract $userContract, string $permission): bool
    {
        return $userContract->hasTeamPermission($this, $permission);
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

    /**
     * Rimuove l'utente specificato dal team.
     *
     * @param UserContract $userContract L'utente da rimuovere dal team
     */
    #[\Override]
    public function removeUser(UserContract $userContract): void
    {
        if ($userContract->current_team_id === $this->id) {
            $userContract->forceFill([
                'current_team_id' => null,
            ])->save();
        }

        $this->users()->detach($userContract);
    }

    /**
     * Rimuove tutte le risorse del team.
     */
    #[\Override]
    public function purge(): void
    {
        $this->owner()->where('current_team_id', $this->id)->update(['current_team_id' => null]);

        $this->users()->where('current_team_id', $this->id)->update(['current_team_id' => null]);

        $this->users()->detach();

        $this->delete();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'user_id' => 'string',
            'personal_team' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
