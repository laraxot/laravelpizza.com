<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ced03f190.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $scont
 * @property string|null $smatr
 * @property string|null $smesli
 * @property string|null $sannli
 * @property string|null $sgiome
 * @property string|null $svocfi
 * @property string|null $perrid
 * @property string|null $totale
 * @property string|null $impoeu
 * @property string|null $totsav
 * @property string|null $impseu
 * @property string|null $qtaore
 * @property string|null $anno
 * @property string|null $mese
 * @property string|null $sruolo
 * @property string|null $impbil
 * @property string|null $clafun
 * @property string|null $flagcf
 * @property string|null $cedist
 *
 * @method static Builder|Ced03f190 newModelQuery()
 * @method static Builder|Ced03f190 newQuery()
 * @method static Builder|Ced03f190 query()
 * @method static Builder|Ced03f190 whereAnno($value)
 * @method static Builder|Ced03f190 whereCedist($value)
 * @method static Builder|Ced03f190 whereClafun($value)
 * @method static Builder|Ced03f190 whereEnte($value)
 * @method static Builder|Ced03f190 whereFlagcf($value)
 * @method static Builder|Ced03f190 whereId($value)
 * @method static Builder|Ced03f190 whereImpbil($value)
 * @method static Builder|Ced03f190 whereImpoeu($value)
 * @method static Builder|Ced03f190 whereImpseu($value)
 * @method static Builder|Ced03f190 whereMese($value)
 * @method static Builder|Ced03f190 wherePerrid($value)
 * @method static Builder|Ced03f190 whereQtaore($value)
 * @method static Builder|Ced03f190 whereSannli($value)
 * @method static Builder|Ced03f190 whereScont($value)
 * @method static Builder|Ced03f190 whereSgiome($value)
 * @method static Builder|Ced03f190 whereSmatr($value)
 * @method static Builder|Ced03f190 whereSmesli($value)
 * @method static Builder|Ced03f190 whereSruolo($value)
 * @method static Builder|Ced03f190 whereSvocfi($value)
 * @method static Builder|Ced03f190 whereTotale($value)
 * @method static Builder|Ced03f190 whereTotsav($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ced03f190Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ced03f190 extends BaseModel
{
    protected $table = 'ced03f190';
}
