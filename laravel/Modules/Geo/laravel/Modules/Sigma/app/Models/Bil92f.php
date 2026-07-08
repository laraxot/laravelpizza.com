<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Bil92f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $annori
 * @property string|null $annoca
 * @property string|null $ruol
 * @property string|null $area1
 * @property string|null $area2
 * @property string|null $gruppo
 * @property string|null $impbil
 * @property string|null $fondo
 * @property string|null $aafon
 * @property string|null $ccfon
 * @property string|null $cproie
 * @property string|null $contra
 * @property string|null $voce
 * @property string|null $ist
 * @property string|null $cosann
 * @property string|null $onepe1
 * @property string|null $onepe2
 * @property string|null $onepe3
 * @property string|null $cospre
 * @property string|null $cosmes
 * @property string|null $one1
 * @property string|null $one2
 * @property string|null $one3
 * @property string|null $proiet
 * @property string|null $proiea
 * @property string|null $proiec
 * @property string|null $proieb
 * @property string|null $proied
 * @property string|null $pone1
 * @property string|null $pone2
 * @property string|null $pone3
 * @property string|null $totcom
 * @property string|null $tone1
 * @property string|null $tone2
 * @property string|null $tone3
 *
 * @method static Builder|Bil92f newModelQuery()
 * @method static Builder|Bil92f newQuery()
 * @method static Builder|Bil92f query()
 * @method static Builder|Bil92f whereAafon($value)
 * @method static Builder|Bil92f whereAnnoca($value)
 * @method static Builder|Bil92f whereAnnori($value)
 * @method static Builder|Bil92f whereArea1($value)
 * @method static Builder|Bil92f whereArea2($value)
 * @method static Builder|Bil92f whereCcfon($value)
 * @method static Builder|Bil92f whereContra($value)
 * @method static Builder|Bil92f whereCosann($value)
 * @method static Builder|Bil92f whereCosmes($value)
 * @method static Builder|Bil92f whereCospre($value)
 * @method static Builder|Bil92f whereCproie($value)
 * @method static Builder|Bil92f whereEnte($value)
 * @method static Builder|Bil92f whereFondo($value)
 * @method static Builder|Bil92f whereGruppo($value)
 * @method static Builder|Bil92f whereId($value)
 * @method static Builder|Bil92f whereImpbil($value)
 * @method static Builder|Bil92f whereIst($value)
 * @method static Builder|Bil92f whereOne1($value)
 * @method static Builder|Bil92f whereOne2($value)
 * @method static Builder|Bil92f whereOne3($value)
 * @method static Builder|Bil92f whereOnepe1($value)
 * @method static Builder|Bil92f whereOnepe2($value)
 * @method static Builder|Bil92f whereOnepe3($value)
 * @method static Builder|Bil92f wherePone1($value)
 * @method static Builder|Bil92f wherePone2($value)
 * @method static Builder|Bil92f wherePone3($value)
 * @method static Builder|Bil92f whereProiea($value)
 * @method static Builder|Bil92f whereProieb($value)
 * @method static Builder|Bil92f whereProiec($value)
 * @method static Builder|Bil92f whereProied($value)
 * @method static Builder|Bil92f whereProiet($value)
 * @method static Builder|Bil92f whereRuol($value)
 * @method static Builder|Bil92f whereTone1($value)
 * @method static Builder|Bil92f whereTone2($value)
 * @method static Builder|Bil92f whereTone3($value)
 * @method static Builder|Bil92f whereTotcom($value)
 * @method static Builder|Bil92f whereVoce($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Bil92fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Bil92f extends BaseModel
{
    protected $table = 'bil92f';
}
