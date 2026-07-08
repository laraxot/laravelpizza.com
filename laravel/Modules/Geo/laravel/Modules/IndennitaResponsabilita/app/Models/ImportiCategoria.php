<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;

/**
 * Modules\IndennitaResponsabilita\Models\ImportiCategoria.
 *
 * @property int $id
 * @property int $ente
 * @property string|null $categoria
 * @property string|null $lista_propro
 * @property int|null $anno
 * @property int|null $min
 * @property int|null $max
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property string|null $deleted_ip
 * @property string|null $created_ip
 * @property string|null $updated_ip
 * @method static Builder|ImportiCategoria newModelQuery()
 * @method static Builder|ImportiCategoria newQuery()
 * @method static Builder|ImportiCategoria query()
 * @method static Builder|ImportiCategoria whereAnno($value)
 * @method static Builder|ImportiCategoria whereCategoria($value)
 * @method static Builder|ImportiCategoria whereCreatedAt($value)
 * @method static Builder|ImportiCategoria whereCreatedBy($value)
 * @method static Builder|ImportiCategoria whereCreatedIp($value)
 * @method static Builder|ImportiCategoria whereDeletedAt($value)
 * @method static Builder|ImportiCategoria whereDeletedBy($value)
 * @method static Builder|ImportiCategoria whereDeletedIp($value)
 * @method static Builder|ImportiCategoria whereEnte($value)
 * @method static Builder|ImportiCategoria whereId($value)
 * @method static Builder|ImportiCategoria whereListaPropro($value)
 * @method static Builder|ImportiCategoria whereMax($value)
 * @method static Builder|ImportiCategoria whereMin($value)
 * @method static Builder|ImportiCategoria whereUpdatedAt($value)
 * @method static Builder|ImportiCategoria whereUpdatedBy($value)
 * @method static Builder|ImportiCategoria whereUpdatedIp($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @method static \Modules\IndennitaResponsabilita\Database\Factories\ImportiCategoriaFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class ImportiCategoria extends BaseModel
{
    protected $table = 'importi_categoria';

    /** @var list<string> */
    protected $fillable = ['id', 'ente', 'categoria', 'lista_propro', 'anno', 'min', 'max', 'created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_at', 'deleted_by', 'deleted_ip', 'created_ip', 'updated_ip'];
}
