<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

use Illuminate\Support\Carbon;

/**
 * Modules\Ptv\Models\CategoriaPropro.
 *
 * @property int $id
 * @property string|null $categoria
 * @property string|null $lista_propro
 * @property string|null $lista_propro_sup
 * @property int|null $posti
 * @property int|null $anno
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Ptv\Database\Factories\CategoriaProproFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CategoriaPropro query()
 *
 * @mixin \Eloquent
 */
class CategoriaPropro extends BaseModel
{
    protected $table = 'categoria_propro';

    protected $fillable = ['id', 'categoria', 'lista_propro', 'lista_propro_sup', 'posti', 'anno'];
}
