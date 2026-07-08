<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\CategoriaProproFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Progressioni\Models\CategoriaPropro.
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
 *
 * @method static CategoriaProproFactory factory($count = null, $state = [])
 * @method static Builder|CategoriaPropro newModelQuery()
 * @method static Builder|CategoriaPropro newQuery()
 * @method static Builder|CategoriaPropro query()
 * @method static Builder|CategoriaPropro whereAnno($value)
 * @method static Builder|CategoriaPropro whereCategoria($value)
 * @method static Builder|CategoriaPropro whereCreatedAt($value)
 * @method static Builder|CategoriaPropro whereCreatedBy($value)
 * @method static Builder|CategoriaPropro whereId($value)
 * @method static Builder|CategoriaPropro whereListaPropro($value)
 * @method static Builder|CategoriaPropro whereListaProproSup($value)
 * @method static Builder|CategoriaPropro wherePosti($value)
 * @method static Builder|CategoriaPropro whereUpdatedAt($value)
 * @method static Builder|CategoriaPropro whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class CategoriaPropro extends BaseModel
{
    protected $table = 'categoria_propro';

    protected $fillable = ['id', 'categoria', 'lista_propro', 'lista_propro_sup', 'posti', 'anno'];
}
