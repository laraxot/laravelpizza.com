<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Modules\Xot\Actions\Module\GetModuleNameByModelClassAction;

/*
 * Undocumented trait.
 */
// @phpstan-ignore trait.unused
trait HasStabiDirigente
{
    public function stabiDirigente(): HasMany
    {
        $static_class = static::class;
        $module = app(GetModuleNameByModelClassAction::class)->execute($static_class);
        $module_low = Str::lower($module);
        $related_key = config($module_low.'::field_map.StabiDirigente.fields.related_key');

        /** @var string|null $related_key */

        $class = Str::of($static_class)
            ->before('\Models\\')
            ->append('\Models\StabiDirigente')
            ->toString();

        /** @var class-string<\Illuminate\Database\Eloquent\Model> $class */
        return $this->hasMany($class, 'stabi', $related_key);
    }
}
