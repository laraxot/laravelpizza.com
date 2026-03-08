<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

// use Modules\Patient\Models\Patient; // Module not available
// use Modules\Dental\Models\Appointment; // Module not available
use Closure;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\User\Models\User;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Modello Tenant per la gestione multi-tenant dell'applicazione.
 *
 * @property string $name
 * @property string $domain
 * @property string $database
 * @property string $slug
 * @property array|null $settings
 * @property bool $is_active
 * @property string|null $logo
 * @property \Carbon\Carbon|null $last_activity_at
 * @property-read string $url
 * @property-read Collection<int, User> $users
 * @property-read int|null $users_count
 *
 * @method static TenantFactory factory($count = null, $state = [])
 * @method static Builder<static>|Tenant newModelQuery()
 * @method static Builder<static>|Tenant newQuery()
 * @method static Builder<static>|Tenant query()
 * @method static Tenant|null first()
 * @method static Collection<int, Tenant> get()
 * @method static Tenant create(array $attributes = [])
 * @method static Tenant firstOrCreate(array $attributes = [], array $values = [])
 * @method static Builder<static>|Tenant where((string|Closure) $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static Builder<static>|Tenant whereNotNull((string|Expression) $columns)
 * @method static int count(string $columns = '*')
 *
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @property ProfileContract|null $deleter
 *
 * @method static Builder<static>|Tenant whereCreatedAt($value)
 * @method static Builder<static>|Tenant whereDatabase($value)
 * @method static Builder<static>|Tenant whereDeletedAt($value)
 * @method static Builder<static>|Tenant whereDomain($value)
 * @method static Builder<static>|Tenant whereId($value)
 * @method static Builder<static>|Tenant whereIsActive($value)
 * @method static Builder<static>|Tenant whereName($value)
 * @method static Builder<static>|Tenant whereSlug($value)
 * @method static Builder<static>|Tenant whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Tenant extends BaseModel
{
    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'domain',
        'database',
        'slug',
        'settings',
        'is_active',
        'logo',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'province',
        'country',
        'tax_code',
        'vat_number',
        'last_activity_at',
    ];

    /**
     * Relazione con gli utenti associati al tenant.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // Commented out - Patient and Dental modules not available
    // /**
    //  * Relazione con i pazienti associati al tenant.
    //  */
    // public function patients(): HasMany
    // {
    //     return $this->hasMany(Patient::class);
    // }

    // /**
    //  * Relazione con gli appuntamenti associati al tenant.
    //  */
    // public function appointments(): HasMany
    // {
    //     return $this->hasMany(Appointment::class);
    // }

    /**
     * Verifica se il tenant è attivo.
     */
    public function isActive(): bool
    {
        $isActive = $attributes['is_active'] ?? false;

        return (bool) $isActive;
    }

    /**
     * Genera lo slug dal nome se non fornito.
     */
    public function setNameAttribute(string $value): void
    {
        $attributes['name'] = $value;

        if (empty($attributes['slug']
            $attributes['slug'] = Str::slug($value);
        }
    }

    /**
     * Restituisce l'URL del tenant.
     */
    public function getUrlAttribute(): string
    {
        $url = $domain ?? config('app.url');

        return is_string($url) ? $url : 'http://localhost';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
            'last_activity_at' => 'datetime',
        ];
    }
}
