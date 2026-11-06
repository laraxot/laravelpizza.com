<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Exports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Stub minimo per verificare gli eager-load di XotBaseExporter::modifyQuery.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ExporterEagerLoadModelStub> $ratings
 */
final class ExporterEagerLoadModelStub extends Model
{
    /**
     * @return HasMany<ExporterEagerLoadModelStub, $this>
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(self::class);
    }

    /**
     * @return HasMany<ExporterEagerLoadModelStub, $this>
     */
    public function ratingMorphs(): HasMany
    {
        return $this->hasMany(self::class);
    }
}
