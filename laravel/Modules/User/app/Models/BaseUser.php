<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Filament\Models\Contracts\FilamentUser;
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
use Spatie\Permission\Traits\HasRoles;

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
 * @method static \Modules\User\Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder|BaseUser                             newModelQuery()
 * @method static Builder|BaseUser                             newQuery()
 * @method static Builder|BaseUser                             query()
 * @method static Builder|BaseUser                             role($roles, $guard = null)
 * @method static Builder|BaseUser                             permission($permissions)
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
            $fillable = array_values($this->getFillable());
            foreach ($attributes as $key => $value) {
                $this->setAttribute($key, $value);
            }
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
        return null;
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
        return (string) $this->password;
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

        return (string) $name;
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
