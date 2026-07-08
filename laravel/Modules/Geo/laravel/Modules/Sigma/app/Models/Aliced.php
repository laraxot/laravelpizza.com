<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Aliced.
 *
 * @property int $id
 * @property int|null $ente
 * @property string|null $conome
 * @property string|null $nome
 * @property int|null $propro
 * @property int|null $posfun
 * @property int|null $scont
 * @property int|null $smatr
 * @property int|null $smesli
 * @property int|null $sannli
 * @property int|null $sgiome
 * @property int|null $svocfi
 * @property string|null $perrid
 * @property int|null $totale
 * @property string|null $impoeu
 * @property int|null $totsav
 * @property string|null $impseu
 * @property string|null $qtaore
 * @property int|null $anno
 * @property int|null $mese
 * @property int|null $sruolo
 * @property int|null $impbil
 * @property int|null $clafun
 * @property int|null $flagcf
 * @property int|null $cedist
 *
 * @method static Builder|Aliced newModelQuery()
 * @method static Builder|Aliced newQuery()
 * @method static Builder|Aliced query()
 * @method static Builder|Aliced whereAnno($value)
 * @method static Builder|Aliced whereCedist($value)
 * @method static Builder|Aliced whereClafun($value)
 * @method static Builder|Aliced whereConome($value)
 * @method static Builder|Aliced whereEnte($value)
 * @method static Builder|Aliced whereFlagcf($value)
 * @method static Builder|Aliced whereId($value)
 * @method static Builder|Aliced whereImpbil($value)
 * @method static Builder|Aliced whereImpoeu($value)
 * @method static Builder|Aliced whereImpseu($value)
 * @method static Builder|Aliced whereMese($value)
 * @method static Builder|Aliced whereNome($value)
 * @method static Builder|Aliced wherePerrid($value)
 * @method static Builder|Aliced wherePosfun($value)
 * @method static Builder|Aliced wherePropro($value)
 * @method static Builder|Aliced whereQtaore($value)
 * @method static Builder|Aliced whereSannli($value)
 * @method static Builder|Aliced whereScont($value)
 * @method static Builder|Aliced whereSgiome($value)
 * @method static Builder|Aliced whereSmatr($value)
 * @method static Builder|Aliced whereSmesli($value)
 * @method static Builder|Aliced whereSruolo($value)
 * @method static Builder|Aliced whereSvocfi($value)
 * @method static Builder|Aliced whereTotale($value)
 * @method static Builder|Aliced whereTotsav($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AlicedFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Aliced extends BaseModel
{
    protected $table = 'aliced';
}
