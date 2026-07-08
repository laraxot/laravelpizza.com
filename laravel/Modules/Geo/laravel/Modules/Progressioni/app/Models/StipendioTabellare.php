<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\StipendioTabellareFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Progressioni\Models\StipendioTabellare.
 *
 * @property int $id
 * @property string|null $categoria
 * @property string|null $lista_propro
 * @property int|null $posfun
 * @property string|null $dal
 * @property string|null $al
 * @property int|null $propro
 * @property string|null $euro_pond
 * @property string|null $ptime
 * @property string|null $euro
 * @property string|null $importo_stipendio_annuo
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 *
 * @method static StipendioTabellareFactory factory($count = null, $state = [])
 * @method static Builder|StipendioTabellare newModelQuery()
 * @method static Builder|StipendioTabellare newQuery()
 * @method static Builder|StipendioTabellare query()
 * @method static Builder|StipendioTabellare whereAl($value)
 * @method static Builder|StipendioTabellare whereAnno($value)
 * @method static Builder|StipendioTabellare whereCategoria($value)
 * @method static Builder|StipendioTabellare whereCreatedAt($value)
 * @method static Builder|StipendioTabellare whereCreatedBy($value)
 * @method static Builder|StipendioTabellare whereDal($value)
 * @method static Builder|StipendioTabellare whereEuro($value)
 * @method static Builder|StipendioTabellare whereEuroPond($value)
 * @method static Builder|StipendioTabellare whereId($value)
 * @method static Builder|StipendioTabellare whereImportoStipendioAnnuo($value)
 * @method static Builder|StipendioTabellare whereListaPropro($value)
 * @method static Builder|StipendioTabellare wherePosfun($value)
 * @method static Builder|StipendioTabellare wherePropro($value)
 * @method static Builder|StipendioTabellare wherePtime($value)
 * @method static Builder|StipendioTabellare whereUpdatedAt($value)
 * @method static Builder|StipendioTabellare whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class StipendioTabellare extends BaseModel
{
    protected $table = 'stipendio_tabellare';

    protected $fillable = ['categoria', 'propro', 'posfun', 'euro_pond', 'ptime', 'euro', 'importo_stipendio_annuo', 'anno'];

    /*
    protected static function boot() {
        parent::boot();
        $anno = date('Y');
        $params = getRouteParameters();
        extract($params);
        if (isset($anno)) {
            static::addGlobalScope('anno', function (Builder $query) use ($anno) {
                $query->where('anno', $anno);
            });
        }
    }
    */
}
