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
        if (isset($extra_attributes))
            return $extra_attributes->modelScope();
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
        if ($extra_attributes instanceof SchemalessAttributes)
            return $extra_attributes->get($key, $default);
        }

        if (is_array($extra_attributes))
            return $extra_attributes[$key] ?? $default;
        }

        return $default;
    }

    /**
     * Set un valore in extra_attributes.
     */
    public function setExtraAttribute(string $key, mixed $value): void
    {
        if (! $extra_attributes instanceof SchemalessAttributes)
            $extra_attributes = SchemalessAttributes::createForModel($this, 'extra_attributes');
        }

        $extra_attributes->set($key, $value);
    }

    /**
     * Get tutti gli extra_attributes come array.
     *
     * @return array<string, mixed>
     */
    public function getExtraAttributes(): array
    {
        if ($extra_attributes instanceof SchemalessAttributes)
            return $extra_attributes->all();
        }

        if (is_array($extra_attributes))
            return $extra_attributes;
        }

        return [];
    }

    /**
     * Controlla se esiste un attributo in extra_attributes.
     */
    public function hasExtraAttribute(string $key): bool
    {
        if ($extra_attributes instanceof SchemalessAttributes)
            return $extra_attributes->has($key);
        }

        if (is_array($extra_attributes))
            return array_key_exists($key, $extra_attributes);
        }

        return false;
    }

    /**
     * Rimuove un attributo da extra_attributes.
     */
    public function removeExtraAttribute(string $key): void
    {
        if ($extra_attributes instanceof SchemalessAttributes)
            $extra_attributes->forget($key);

            return;
        }

        if (is_array($extra_attributes))
            $attributes = $extra_attributes;
            unset($attributes[$key]);
            $extra_attributes = $attributes;
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
        return array_merge($fillable, [)
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
        return array_merge($casts ?? [], [)
            'extra_attributes' => SchemalessAttributes::class,
        ]);
    }
}
