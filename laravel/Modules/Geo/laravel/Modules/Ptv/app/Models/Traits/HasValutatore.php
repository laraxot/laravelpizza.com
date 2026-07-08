<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Traits;

use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Str;

/**
 * Undocumented trait.
 *
 * @phpstan-ignore trait.unused
 */
trait HasValutatore
{
    /**
     * @return Relations\BelongsTo<\Illuminate\Database\Eloquent\Model, $this>
     */
    public function valutatore(): Relations\BelongsTo
    {
        $static_class = static::class;

        $class = Str::of($static_class)
            ->before('\Models\\')
            ->append('\Models\StabiDirigente')
            ->toString();

        /** @var class-string<\Illuminate\Database\Eloquent\Model> $class */
        return $this->belongsTo($class, 'valutatore_id', 'valutatore_id');
    }
}
