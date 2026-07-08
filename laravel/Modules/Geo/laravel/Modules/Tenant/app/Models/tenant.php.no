<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Models\User;

/**
 * Modello Tenant per la gestione multi-tenant dell'applicazione.
 */
class Tenant extends BaseModel
{
    // use SoftDeletes;



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
    ];

    /**
     * Gli attributi da castare.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relazione con gli utenti associati al tenant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

   
    /*
     * Verifica se il tenant è attivo.
     *
     * @return bool
     
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
        */

    /**
     * Genera lo slug dal nome se non fornito.
     *
     * @param string $value
     * @return void
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;

        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = \Str::slug($value);
        }
    }

    /**
     * Restituisce l'URL del tenant.
     *
     * @return string
     */
    public function getUrlAttribute(): string
    {
        return $this->domain ?? config('app.url');
    }
}
