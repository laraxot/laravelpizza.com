<?php

declare(strict_types=1);

namespace Modules\User\Models;

<<<<<<< HEAD
||||||| 6161e129d
use Exception;
=======
use Filament\Models\Contracts\FilamentUser;
>>>>>>> feature/ralph-loop-implementation
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Traits\HasModules;
use Modules\User\Models\Traits\HasSocialite;
use Modules\User\Models\Traits\HasTeams;
use Modules\User\Models\Traits\HasTenants;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Modules\Xot\Traits\Updater;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
<<<<<<< HEAD
||||||| 6161e129d
use Throwable;
=======
use Spatie\Permission\Traits\HasRoles;
>>>>>>> feature/ralph-loop-implementation

/**
 * Modules\User\Models\BaseUser.
 *
 * @property int                                                                                                       $id
 * @property string|null                                                                                               $handle
 * @property string|null                                                                                               $first_name
 * @property string|null                                                                                               $last_name
 * @property string|null                                                                                               $email
 * @property \DateTime|null                                                                                            $email_verified_at
 * @property string|null                                                                                               $password
 * @property string|null                                                                                               $remember_token
 * @property \Illuminate\Support\Carbon|null                                                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                                                           $updated_at
 * @property string|null                                                                                               $created_by
 * @property string|null                                                                                               $updated_by
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property int|null                                                                                                  $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection|Role[]                                                           $roles
 * @property int|null                                                                                                  $roles_count
 * @property \Illuminate\Database\Eloquent\Collection|Permission[]                                                     $permissions
 * @property int|null                                                                                                  $permissions_count
 *
<<<<<<< HEAD
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
||||||| 6161e129d
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
 * @property Collection<int, Team> $teams
 * @property int|null $teams_count
 * @property Collection<int, Tenant> $tenants
 * @property int|null $tenants_count
 * @property Collection<int, OauthAccessToken> $tokens
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
=======
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder|BaseUser                             newModelQuery()
 * @method static Builder|BaseUser                             newQuery()
 * @method static Builder|BaseUser                             query()
 * @method static Builder|BaseUser                             role($roles, $guard = null)
 * @method static Builder|BaseUser                             permission($permissions)
>>>>>>> feature/ralph-loop-implementation
 *
 * @mixin \Eloquent
 */
class BaseUser extends Authenticatable implements FilamentUser, HasName, UserContract, HasMedia
{
    use HasApiTokens;
    use HasRoles;
    use HasXotFactory;
    use Notifiable;
    use Updater;
    use HasTeams;
    use HasTenants;
    use HasSocialite;
    use HasModules;
    use InteractsWithMedia;

    /** @var string */
    protected $connection = 'mysql';

    /** @var string */
    protected $table = 'users';

    /** @var list<string> */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'password',
        'handle',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        // array_values() garantisce che sia un array indicizzato (list<string>)
        try {
            $fillable = array_values(array_merge(parent::getFillable(), $this->fillable));
            $this->fillable($fillable);
            parent::__construct($attributes);
        } catch (\Throwable $e) {
            // Fallback in case database connection is not available (e.g., during testing)
<<<<<<< HEAD
            $this->fillable = array_values($this->getFillable());
            $this->fillable = array_values($this->getFillable());
            // Avoid calling parent constructor if database is not available
            /* @var array<string, mixed> $attributes */
            $this->attributes = $attributes;
||||||| 6161e129d
            $this->fillable = array_values($this->getFillable());
            // Avoid calling parent constructor if database is not available
            foreach ($attributes as $key => $value) {
                $this->setAttribute($key, $value);
            }
=======
            $fillable = array_values($this->getFillable());
            foreach ($attributes as $key => $value) {
                $this->setAttribute($key, $value);
            }
>>>>>>> feature/ralph-loop-implementation
        }
    }

    public function getProviderName(): string
    {
        return (string) $this->getAttribute('provider');
    }

    public function canAccessFilament(?Panel $panel = null): bool
    {
        return true;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the user's name for Filament.
     */
    public function getFilamentName(): string
    {
        $name = (string) $this->getAttribute('name');
        $email = (string) $this->getAttribute('email');

        if (! empty($name)) {
            return $name;
        }

        return ! empty($email) ? $email : 'User';
    }

    /**
     * Get the user's avatar for Filament.
     */
    public function getFilamentAvatarUrl(): ?string
    {
<<<<<<< HEAD
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
||||||| 6161e129d
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
        if ($panel->getId() !== 'admin') {
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
        return $this->teams ?? new Collection;
=======
        return null;
>>>>>>> feature/ralph-loop-implementation
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string|array<string, string>|null
     */
    public function routeNotificationForMail($notification)
    {
        return $this->email;
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword(): string
    {
<<<<<<< HEAD
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
||||||| 6161e129d
        return $this->hasMany(SocialiteUser::class);
    }

    public function getProviderField(string $provider, string $field): string
    {
        $socialiteUser = $this->socialiteUsers()->firstWhere(['provider' => $provider]);
        if ($socialiteUser === null) {
            throw new Exception('SocialiteUser not found');
        }

        $res = $socialiteUser->{$field};

        return (string) $res;
=======
        return (string) $this->password;
>>>>>>> feature/ralph-loop-implementation
    }

    /**
     * Determine if the user has verified their email address.
     */
    public function hasVerifiedEmail(): bool
    {
        return null !== $this->email_verified_at;
    }

    /**
     * Mark the given user's email as verified.
     */
    public function markEmailAsVerified(): bool
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Get the profile associated with the user.
     */
    public function profile(): MorphOne
    {
        return $this->morphOne(Profile::class, 'user');
    }

    /**
     * Get the authentications for the user.
     */
    public function authentications(): MorphMany
    {
        return $this->morphMany(AuthenticationLog::class, 'authenticatable');
    }

    /**
     * Get the latest authentication for the user.
     */
    public function latestAuthentication(): MorphOne
    {
        return $this->morphOne(AuthenticationLog::class, 'authenticatable')->latestOfMany();
    }

    public function getFullNameAttribute(?string $value): string
    {
        if (null !== $value) {
            return $value;
        }

        $firstName = (string) $this->getAttribute('first_name');
        $lastName = (string) $this->getAttribute('last_name');
        $fullName = trim($firstName.' '.$lastName);

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

        $email = (string) $this->getAttribute('email');
        $name = Str::of($email);
        $i = 1;
        $candidate = $name.'-'.$i;

<<<<<<< HEAD
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
||||||| 6161e129d
        // During unit tests, avoid any DB interaction.
        $isTesting = (static function (): bool {
            $app = app();
            if (method_exists($app, 'environment') && $app->environment('testing')) {
                return true;
            }

            return \PHP_SAPI === 'cli' && (getenv('APP_ENV') === 'testing' || getenv('ENV') === 'testing');
        })();
        if ($isTesting) {
            // Do not call update() here to avoid hitting the database.
            $this->attributes['name'] = $candidate;

            return $candidate;
        }

        try {
            $value = $candidate;
            while (self::firstWhere(['name' => $value]) !== null) {
                $i++;
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
=======
        return (string) $name;
>>>>>>> feature/ralph-loop-implementation
    }

    /**
     * Find the user instance for the given username (Passport).
     */
    public static function findForPassport(string $username): ?self
    {
        return static::where('email', $username)->first();
    }

    /**
     * Validate the password of the user for the given password (Passport).
     */
    public function validateForPassportPasswordGrant(string $password): bool
    {
        return \Hash::check($password, $this->password);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<static>
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
