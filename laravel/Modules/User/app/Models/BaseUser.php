<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Modules\User\Contracts\HasAuthentications;
use Modules\User\Contracts\HasTeamsContract;
use Modules\User\Contracts\UserNotificationsContract;
use Modules\User\Models\Traits\BaseUserMutators;
use Modules\User\Models\Traits\BaseUserRelations;
use Modules\User\Models\Traits\HasAuthenticationLogTrait;
use Modules\User\Models\Traits\HasDevices;
use Modules\User\Models\Traits\HasModules;
use Modules\User\Models\Traits\HasSocialite;
use Modules\User\Models\Traits\HasSpatiePermission;
use Modules\User\Models\Traits\HasTeams;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Traits as XotTraits;
use Modules\Xot\Models\Traits\HasXotFactory;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Models\Permission;

/**
 * Base User Model.
 *
 * This is the base user model that provides the core authentication and authorization
 * functionality for the application. It extends Laravel's Authenticatable class
 * and implements the required interfaces for Filament and multi-tenancy.
 *
 * @property Collection<int, OauthClient> $clients
 * @property int|null $clients_count
 * @property Team|null $currentTeam
 * @property Collection<int, Device> $devices
 * @property int|null $devices_count
 * @property string|null $full_name
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property int|null $notifications_count
 * @property Collection<int, Team> $ownedTeams
 * @property int|null $owned_teams_count
 * @property Collection<int, Permission> $permissions
 * @property int|null $permissions_count
 * @property ProfileContract|null $profile
 * @property Collection<int, Role> $roles
 * @property int|null $roles_count
 * @property Collection<int, Team> $membershipTeams
 * @property int|null $membership_teams_count
 * @property Collection<int, Tenant> $tenants
 * @property int|null $tenants_count
 * @property Collection<int, OauthToken> $tokens
 * @property int|null $tokens_count
 * @property string $last_name
 * @property string|null $facebook_id
 * @property Collection<int, SocialiteUser> $socialiteUsers
 * @property int|null $socialite_users_count
 * @property string|null $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $password
 * @property string|null $lang
 * @property string|null $current_team_id
 * @property bool|null $is_active
 * @property bool|null $is_otp
 * @property string|null $type
 * @property \DateTime|null $password_expires_at
 * @property \DateTime|null $email_verified_at
 * @property string|null $remember_token
 * @property \DateTime|null $created_at
 * @property \DateTime|null $updated_at
 * @property \DateTime|null $deleted_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_by
 * @property string|null $profile_photo_path
 * @property Pivot|null $pivot
 *
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions, $without = false)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null, $without = false)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereCreatedBy($value)
 * @method static Builder|User whereCurrentTeamId($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDeletedBy($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsActive($value)
 * @method static Builder|User whereLang($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereProfilePhotoPath($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUpdatedBy($value)
 * @method static Builder|User withoutPermission($permissions)
 * @method static Builder|User withoutRole($roles, $guard = null)
 * @method static Builder|User whereFacebookId($value)
 * @method static Builder|User whereIsOtp($value)
 * @method static Builder|User wherePasswordExpiresAt($value)
 * @method static Builder|User whereSurname($value)
 *
 * @mixin \Eloquent
 */
abstract class BaseUser extends Authenticatable implements FilamentUser, HasAuthentications, HasMedia, HasName, HasTeamsContract, HasTenants, MustVerifyEmail, OAuthenticatable, UserContract, UserNotificationsContract
{
    use BaseUserMutators, BaseUserRelations, HasSpatiePermission, HasTeams, Notifiable, HasAuthenticationLogTrait {
        HasSpatiePermission::teams insteadof HasTeams;
        HasTeams::teams as membershipTeams;
        BaseUserRelations::notifications insteadof Notifiable;
        BaseUserRelations::unreadNotifications insteadof Notifiable;
        BaseUserRelations::clients insteadof HasApiTokens;
        BaseUserRelations::latestAuthentication as baseUserRelationsLatestAuthentication;
        HasAuthenticationLogTrait::latestAuthentication insteadof BaseUserRelations;
    }
    use HasApiTokens;
    use HasChildren;
    use HasDevices;
    use HasModules;
    use HasSocialite;
    use HasUuids;
    use HasXotFactory;
    use InteractsWithMedia;

    // use SoftDeletes;
    use Traits\HasTenants;
    use XotTraits\RelationX;

    public $incrementing = false;

    protected $connection = 'user';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected string $childColumn = 'type';

    protected $fillable = [
        'id',
        // 'ente',
        // 'matr',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'lang',
        'current_team_id',
        'is_active',
        'is_otp', // is One Time Password
        'password_expires_at',
        'email_verified_at',
        'type',
        'state',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /** @var list<string> */
    protected $with = [
        // Removed 'roles' to reduce memory usage - load explicitly when needed
    ];

    /** @var list<string> */
    protected $appends = [
        // 'profile_photo_url',
    ];

    /** @var array<string, class-string> */
    protected $childTypes = [];

    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Guard coerente con Spatie/Permission: deve essere 'web'.
     */
    protected string $guard_name = 'web';

    public function __construct(array $attributes = [])
    {
        // Concateno i fillable del parent con quelli della classe corrente
        // array_values() garantisce che sia un array indicizzato (list<string>)
        try {
            $this->fillable = array_values(array_merge(parent::getFillable(), $this->getFillable()));
            parent::__construct($attributes);
        } catch (\Throwable $e) {
            // Fallback in case database connection is not available (e.g., during testing)
            $this->fillable = array_values($this->getFillable());
            // Avoid calling parent constructor if database is not available
            foreach ($attributes as $key => $value) {
                $this->setAttribute($key, $value);
            }
        }
    }

    public function getProviderName(): string
    {
        $provider = $this->getAttribute('provider');
        if (\is_string($provider) && $provider !== '') {
            return $provider;
        }

        $configured = config('auth.guards.api.provider', 'users');

        return \is_string($configured) ? $configured : 'users';
    }

    /*
    public function canAccessFilament(?Panel $panel = null): bool
    {
         dddx($panel->getId());
        // return $this->role_id === DefaultRoleId::Administrator->value;
        return true;
    }
    */
    /**
     * Get the user's name for Filament.
     */
    public function getFilamentName(): string
    {
        $name = $this->name ?? '';
        $firstName = $this->first_name ?? '';
        $lastName = $this->last_name ?? '';

        $fullName = trim(\sprintf('%s %s %s', $name, $firstName, $lastName));

        // Ensure we always return a non-empty string
        if (empty($fullName)) {
            $email = $this->email ?? '';

            return ! empty($email) ? $email : 'User';
        }

        return $fullName;
    }

    /**
     * Verifica se l'utente ha il ruolo di super-admin.
     *
     * @return bool True se l'utente Ã¨ super-admin, altrimenti false
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function assignModule(string $module): void
    {
        $role_name = $module.'::admin';
        $role = Role::firstOrCreate(['name' => $role_name]);
        $this->assignRole($role);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // $panel->default('admin');
        if ($panel->getId() === 'access') {
            return true;
        }

        // Admin e super admin entrano solo nel pannello di amministrazione del ristorante (`restaurant::admin`): il pannello principale `admin`
        // li rimanderebbe alla home del sito. Comanda, cassa, cucina, banco e HACCP restano dei rispettivi ruoli.
        if ($panel->getId() === 'restaurant::admin' && $this->hasAnyRole(['super-admin', 'admin'])) {
            return true;
        }

        if ($panel->getId() !== 'admin') {
            $role = $panel->getId();

            // App\Support\AccountFeatures non e' mai esistita (ne' la classe ne'
            // config/account_features.php): riferimento morto fin dal commit
            // iniziale del modulo, causava un Error fatale a runtime su ogni
            // pannello diverso da "admin". hasRole($role) resta l'unico controllo
            // reale, come gia' documentato qui sopra come fallback.
            return $this->hasRole($role);
        }

        return $this->hasAnyRole(['super-admin', 'admin', 'restaurant::admin']);
    }

    public function detach(Model $model): void
    {
        $this->membershipTeams()->detach($model);
    }

    public function attach(Model $model): void
    {
        $this->membershipTeams()->attach($model);
    }

    public function treeLabel(): string
    {
        return (string) ($this->name ?? $this->email);
    }

    /**
     * @return Collection<int, Team>
     */
    /**
     * @return Collection<int, Team>
     */
    public function treeSons(): Collection
    {
        return $this->membershipTeams ?? new Collection;
    }

    // public function authentications(): MorphMany
    // {
    //    return $this->morphMany(\Modules\User\Models\Authentication::class, 'authenticatable');
    // }

    /**
     * Find the user instance for the given username.
     */
    public static function findForPassport(string $username): ?self
    {
        return static::where('email', $username)->first();
    }

    /**
     * Validate the password of the user for the given password.
     */
    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, (string) $this->password);
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'email_verified_at' => 'datetime',
            // 'password' => 'hashed', //Call to undefined cast [hashed] on column [password] in model [Modules\User\Models\User].
            'is_active' => 'boolean',
            'roles.pivot.id' => 'string',
            // https://github.com/beitsafe/laravel-uuid-auditing
            // ALTER TABLE model_has_role CHANGE COLUMN `id` `id` CHAR(37) NOT NULL DEFAULT uuid();

            'is_otp' => 'boolean',
            'password_expires_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
        ];
    }
}