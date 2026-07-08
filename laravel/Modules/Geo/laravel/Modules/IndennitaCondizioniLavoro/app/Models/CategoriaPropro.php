<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models;

use Modules\Ptv\Models\CategoriaPropro as PtvCategoriaPropro;

/**
 * Modules\IndennitaCondizioniLavoro\Models\CategoriaPropro.
 *
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\IndennitaCondizioniLavoro\Database\Factories\CategoriaProproFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro query()
 * @mixin \Eloquent
 */
class CategoriaPropro extends PtvCategoriaPropro
{
    protected $connection = 'indennita_condizioni_lavoro';
}
