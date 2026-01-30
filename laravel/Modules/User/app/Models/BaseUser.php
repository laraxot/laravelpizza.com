<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Traits\HasAuthenticationLogTrait;
use Modules\User\Models\Traits\HasModules;
use Modules\User\Models\Traits\HasSpatiePermission;
use Modules\User\Models\Traits\HasTeams;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Models\Traits as XotTraits;
use Modules\Xot\Models\Traits\HasXotFactory;
use Parental\HasChildren;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Base User Model.
 *
 * This is the base user model that provides the core authentication and authorization
 * functionality for the application. It extends Laravel's Authenticatable class
 * and implements the required interfaces for Filament and multi-tenancy.
 *
 * @property Collection<int, OauthClient>                              $clients
 * @property int|null                                                  $clients_count
 * @property Team|null                                                 $currentTeam
 * @property Collection<int, Device>                                   $devices
 * @property int|null                                                  $devices_count
 * @property string|null                                               $full_name
 * @property DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property int|null                                                  $notifications_count
 * @property Collection<int, Team>                                     $ownedTeams
 * @property int|null                                                  $owned_teams_count
 * @property Collection<int, Permission>                               $permissions
 * @property int|null                                                  $permissions_count
 * @property ProfileContract|null                                      $profile
 * @property Collection<int, Role>                                     $roles
 * @property int|null                                                  $roles_count
 * @property Collection<int, Team>                                     $teams
 * @property int|null                                                  $teams_count
 * @property Collection<int, Tenant>                                   $tenants
 * @property int|null                                                  $tenants_count
 * @property Collection<int, OauthAccessToken>                         $tokens
 * @property int|null                                                  $tokens_count
 * @property string                                                    $last_name
 * @property string|null                                               $facebook_id
 * @property Collection<int, SocialiteUser>                            $socialiteUsers
 * @property int|null                                                  $socialite_users_count
 * @property string|null                                               $name
 * @property string|null                                               $first_name
 * @property string|null                                               $last_name
 * @property string|null                                               $email
 * @property string|null                                               $password
 * @property string|null                                               $lang
 * @property string|null                                               $current_team_id
 * @property bool|null                                                 $is_active
 * @property bool|null                                                 $is_otp
 * @property string|null                                               $type
 * @property \DateTime|null                                            $password_expires_at
 * @property \DateTime|null                                            $email_verified_at
 * @property string|null                                               $remember_token
 * @property \DateTime|null                                            $created_at
 * @property \DateTime|null                                            $updated_at
 * @property \DateTime|null                                            $deleted_at
 * @property string|null                                               $created_by
 * @property string|null                                               $updated_by
 * @property string|null                                               $deleted_by
 * @property string|null                                               $profile_photo_path
 * @property Pivot|null                                                $pivot
 *
 * @method static UserFactory  factory($count = null, $state = [])
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
abstract class BaseUser extends Authenticatable implements HasMedia, HasName, HasTenants, MustVerifyEmail, OAuthenticatable, UserContract
{
    use HasApiTokens;
    use HasAuthenticationLogTrait;
    use HasChildren;
    use HasModules;
    use HasSpatiePermission;
    use HasTeams;
    use HasUuids;
    use HasXotFactory;
    use InteractsWithMedia;
    use Notifiable;
    use SoftDeletes;
    use Traits\HasTenants;
    use XotTraits\RelationX;

    /** @var bool */
    public $incrementing = false;

    /** @var Pivot|null */
    public $pivot;

    /** @var string */
    protected $connection = 'user';

    /** @var string */
    protected $primaryKey = 'id';

    /** @var string */
    protected $keyType = 'string';

    /** @var string */
    protected $childColumn = 'type';

    /** @var list<string> */
    protected $fillable = [
        'id',
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
        'type',
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

    /** @var array<string, mixed> */
    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Guard coerente con Spatie/Permission: deve essere 'web'.
     *
     * @var string
     */
    protected $guard_name = 'web';

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
            $this->attributes = $attributes;
        }
    }

    public function getProviderName(): string
    {
        return (string) ($this->getAttribute('provider') ?? config('auth.guards.api.provider', 'users'));
    }

    public function canAccessFilament(?Panel $panel = null): bool
    {
        // return $this->role_id === Role::ROLE_ADMINISTRATOR;
        return true;
    }

    /**
     * Get the user's name for Filament.
     */
    public function getFilamentName(): string
    {
        $name = (string) ($this->getAttribute('name') ?? '');
        $firstName = (string) ($this->getAttribute('first_name') ?? '');
        $lastName = (string) ($this->getAttribute('last_name') ?? '');

        $fullName = trim(\sprintf('%s %s %s', $name, $firstName, $lastName));

        // Ensure we always return a non-empty string
        if (empty($fullName)) {
            $email = (string) ($this->getAttribute('email') ?? '');

            return ! empty($email) ? $email : 'User';
        }

        return $fullName;
    }

    #[\Override]
    public function profile(): HasOne
    {
        $profileClass = XotData::make()->getProfileClass();
        if (class_exists($profileClass)) {
            return $this->hasOne($profileClass);
        }

        // Try direct module class if XotData failed
        $directClass = 'Modules\User\Models\Profile';
        if (class_exists($directClass)) {
            return $this->hasOne($directClass);
        }

        // Fallback: stay on current model if nothing found
        return $this->hasOne(static::class, 'id', 'id')->whereRaw('1=0');
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
        if ('admin' !== $panel->getId()) {
            $role = $panel->getId();
            /*
             * $xot = XotData::make();
             * if ($xot->super_admin === $this->email) {
             * $role = Role::firstOrCreate(['name' => $role]);
             * $this->assignRole($role);
             * }
             */

            return $this->hasRole($role);
        }

        return true; // str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

    public function canAccessSocialite(): bool
    {
        return true;
    }

    public function detach(Model $model): void
    {
        // @phpstan-ignore function.alreadyNarrowedType
        if (method_exists($this, 'teams')) {
            // @phpstan-ignore function.alreadyNarrowedType
            $this->teams()->detach($model);
        }
    }

    public function attach(Model $model): void
    {
        // @phpstan-ignore function.alreadyNarrowedType
        if (method_exists($this, 'teams')) {
            // @phpstan-ignore function.alreadyNarrowedType
            $this->teams()->attach($model);
        }
    }

    public function treeLabel(): string
    {
        return (string) ($this->name ?? $this->email);
    }

    public function treeSons(): Collection
    {
        return $this->teams ?? new Collection();
    }

    /**
     * Get the devices associated with the user.
     *
     * @return BelongsToMany<Device, static>
     */
    public function devices(): BelongsToMany
    {
        return $this->belongsToManyX(Device::class);
    }

    /**
     * Get the socialite users associated with the user.
     *
     * @return HasMany<SocialiteUser, $this>
     */
    public function socialiteUsers(): HasMany
    {
        return $this->hasMany(SocialiteUser::class);
    }

    public function getProviderField(string $provider, string $field): string
    {
        $socialiteUser = $this->socialiteUsers()->firstWhere(['provider' => $provider]);
        if (null === $socialiteUser) {
            throw new \Exception('SocialiteUser not found');
        }

        $res = $socialiteUser->{$field};

        return (string) $res;
    }

    /**
     * Get the entity's notifications.
     *
     * @return MorphMany<Notification, static|$this>
     */
    public function notifications(): MorphMany
    {
        // @phpstan-ignore return.type
        return $this->morphMany(Notification::class, 'notifiable');
    }

    /**
     * Get the user's latest authentication log.
     *
     * @return MorphOne<AuthenticationLog, static>
     */
    public function latestAuthentication(): MorphOne
    {
        // @phpstan-ignore return.type
        return $this->morphOne(AuthenticationLog::class, 'authenticatable')->latestOfMany();
    }

    public function getFullNameAttribute(?string $value): string
    {
        if (null !== $value) {
            return $value;
        }

        $fullName = trim(($this->first_name ?? '').' '.($this->last_name ?? ''));

        return '' !== $fullName ? $fullName : ($this->email ?? 'User');
    }

    public function getNameAttribute(?string $value): string
    {
        if (null !== $value) {
            return $value;
        }

        if (null === $this->getKey()) {
            return $this->email ?? 'User';
        }

        $name = Str::of((string) $this->email)->before('@')->toString();
        $i = 1;
        $candidate = $name.'-'.$i;

        // During unit tests, avoid any DB interaction.
        $isTesting = (static function (): bool {
            $app = app();
            if (method_exists($app, 'environment') && $app->environment('testing')) {
                return true;
            }

            return \PHP_SAPI === 'cli' && ('testing' === getenv('APP_ENV') || 'testing' === getenv('ENV'));
        })();
        if ($isTesting) {
            // Do not call update() here to avoid hitting the database.
            $this->attributes['name'] = $candidate;

            return $candidate;
        }

        try {
            $value = $candidate;
            while (null !== self::firstWhere(['name' => $value])) {
                ++$i;
                $value = $name.'-'.$i;
            }
            $this->update(['name' => $value]);

            return $value;
        } catch (\Throwable $e) {
            // If any issue occurs (e.g., missing connection/table), fall back without DB.
            $this->attributes['name'] = $candidate;

            return $candidate;
        }
    }

    // public function authentications(): MorphMany
    // {
    //    return $this->morphMany(\Modules\User\Models\Authentication::class, 'authenticatable');
    // }

    /**
     * Check if the user has a specific role.
     *
     * NOTE: This method has been moved to trait HasSpatiePermission.
     * If you need role checking functionality, use the trait method instead.
     *
     * @see HasSpatiePermission::hasRole()
     */
    public function setPasswordAttribute(?string $value): void
    {
        if (empty($value)) {
            unset($this->attributes['password']);

            return;
        }
        if (\strlen($value) < 32) {
            $this->attributes['password'] = Hash::make($value);

            return;
        }
        $this->attributes['password'] = $value;
    }

    /**
     * User possiede molti Clients OAuth (per autenticazione API).
     *
     * @return MorphMany<OauthClient, $this>
     */
    public function clients(): MorphMany
    {
        return $this->morphMany(OauthClient::class, 'owner');
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
}
