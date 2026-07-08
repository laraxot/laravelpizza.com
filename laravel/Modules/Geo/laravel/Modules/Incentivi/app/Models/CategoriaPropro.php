<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Modules\Ptv\Models\CategoriaPropro as PtvCategoriaPropro;

/**
 * Modules\Incentivi\Models\CategoriaPropro.
 *
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Incentivi\Database\Factories\CategoriaProproFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro query()
 * @mixin \Eloquent
 */
class CategoriaPropro extends PtvCategoriaPropro
{
    protected $connection = 'incentivi';
}
