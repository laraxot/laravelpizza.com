<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Support\Str;

trait TenantMutators
{
    /**
     * Genera lo slug dal nome se non fornito.
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = $value;

        $slug = $this->attributes['slug'] ?? null;
        if (! is_string($slug) || $slug === '') {
            $this->attributes['slug'] = Str::slug($value);
        }
    }

    public function getNameAttribute(): ?string
    {
        return $this->getName();
    }

    public function getName(): ?string
    {
        $name = $this->attributes['name'] ?? null;

        return is_string($name) ? $name : null;
    }

    /**
     * Restituisce l'URL del tenant.
     */
    public function getUrlAttribute(): string
    {
        return $this->getUrl();
    }

    public function getUrl(): string
    {
        $url = $this->domain ?? config('app.url');

        return is_string($url) ? $url : 'http://localhost';
    }
}
