<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Illuminate\Support\Str;

/**
 * Trait HasUuid.
 *
 * Adds a separate 'uuid' column that is automatically generated on creation.
 * This is NOT for using UUID as the primary key.
 */
trait HasUuid
{
    /**
     * Boot the trait.
     */
    protected static function bootHasUuid(): void
    {
        static::creating(static function ($model): void {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Initialize the trait.
     */
    public function initializeHasUuid(): void
    {
        $this->mergeCasts(['uuid' => 'string']);
    }
}
