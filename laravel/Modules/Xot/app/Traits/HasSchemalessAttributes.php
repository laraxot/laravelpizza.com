<?php

declare(strict_types=1);

namespace Modules\Xot\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * Trait per implementare Schemaless Attributes in modo consistente.
 *
 * Fornisce metodi standard per lavorare con extra_attributes
 * seguendo le best practices di Spatie.
 *
 * @see https://github.com/spatie/laravel-schemaless-attributes
 */
trait HasSchemalessAttributes
{
    /**
     * Scope per filtrare per attributi schemaless.
     */
    public function scopeWithExtraAttributes(Builder $query): Builder
    {
        if (isset($this->extra_attributes) && is_object($this->extra_attributes)) {
            return $this->extra_attributes->modelScope();
        }

        return $query;
    }

    /**
     * Scope per query specifiche su extra_attributes.
     */
    public function scopeWhereExtraAttribute(Builder $query, string $key, mixed $value): Builder
    {
        return $query->where("extra_attributes->{$key}", $value);
    }

    /**
     * Get un valore da extra_attributes.
     */
    public function getExtraAttribute(string $key, mixed $default = null): mixed
    {
        if ($this->extra_attributes instanceof SchemalessAttributes) {
            return $this->extra_attributes->get($key, $default);
        }

        if (is_array($this->extra_attributes)) {
            return $this->extra_attributes[$key] ?? $default;
        }

        return $default;
    }

    /**
     * Set un valore in extra_attributes.
     */
    public function setExtraAttribute(string $key, mixed $value): void
    {
        if (! $this->extra_attributes instanceof SchemalessAttributes) {
            $this->extra_attributes = SchemalessAttributes::createForModel($this, 'extra_attributes');
        }

        $this->extra_attributes->set($key, $value);
    }

    /**
     * Get tutti gli extra_attributes come array.
     *
     * @return array<string, mixed>
     */
    public function getExtraAttributes(): array
    {
        if ($this->extra_attributes instanceof SchemalessAttributes) {
            return $this->extra_attributes->all();
        }

        if (is_array($this->extra_attributes)) {
            return $this->extra_attributes;
        }

        return [];
    }

    /**
     * Controlla se esiste un attributo in extra_attributes.
     */
    public function hasExtraAttribute(string $key): bool
    {
        if ($this->extra_attributes instanceof SchemalessAttributes) {
            return $this->extra_attributes->has($key);
        }

        if (is_array($this->extra_attributes)) {
            return array_key_exists($key, $this->extra_attributes);
        }

        return false;
    }

    /**
     * Rimuove un attributo da extra_attributes.
     */
    public function removeExtraAttribute(string $key): void
    {
        if ($this->extra_attributes instanceof SchemalessAttributes) {
            $this->extra_attributes->forget($key);
        }

        if (is_array($this->extra_attributes)) {
            unset($this->extra_attributes[$key]);
        }
    }

    /**
     * Sincronizza gli extra_attributes con il database.
     */
    public function syncExtraAttributes(): void
    {
        $this->save();
    }

    /**
     * Aggiunge extra_attributes al fillable.
     *
     * @return array<string>
     */
    protected function schemalessFillable(): array
    {
        return array_merge($this->fillable, [
            'extra_attributes',
        ]);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function schemalessCasts(): array
    {
        return array_merge($this->casts ?? [], [
            'extra_attributes' => SchemalessAttributes::class,
        ]);
    }
}
