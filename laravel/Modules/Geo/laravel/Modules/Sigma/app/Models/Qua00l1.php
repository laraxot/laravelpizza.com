<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua00l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $cont
 * @property string|null $matr
 * @property string|null $tipco
 * @property string|null $rapp
 * @property string|null $ruolo
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $codqua
 * @property string|null $qudal
 * @property string|null $qual
 * @property string|null $quanz
 * @property string|null $posiz
 * @property string|null $sipco
 * @property string|null $sapp
 * @property string|null $suolo
 * @property string|null $sropro
 * @property string|null $sosfun
 * @property string|null $sodqua
 * @property string|null $annise
 * @property string|null $prvtip
 * @property string|null $prvdat
 * @property string|null $prvnum
 * @property string|null $datpas
 * @property string|null $serviz
 * @property string|null $disci1
 * @property string|null $disci2
 * @property string|null $oree
 * @property string|null $oret
 * @property string|null $aapens
 * @property string|null $quaann
 *
 * @method static Builder|Qua00l1 newModelQuery()
 * @method static Builder|Qua00l1 newQuery()
 * @method static Builder|Qua00l1 query()
 * @method static Builder|Qua00l1 whereAapens($value)
 * @method static Builder|Qua00l1 whereAnnise($value)
 * @method static Builder|Qua00l1 whereCodqua($value)
 * @method static Builder|Qua00l1 whereCont($value)
 * @method static Builder|Qua00l1 whereDatpas($value)
 * @method static Builder|Qua00l1 whereDisci1($value)
 * @method static Builder|Qua00l1 whereDisci2($value)
 * @method static Builder|Qua00l1 whereEnte($value)
 * @method static Builder|Qua00l1 whereId($value)
 * @method static Builder|Qua00l1 whereMatr($value)
 * @method static Builder|Qua00l1 whereOree($value)
 * @method static Builder|Qua00l1 whereOret($value)
 * @method static Builder|Qua00l1 wherePosfun($value)
 * @method static Builder|Qua00l1 wherePosiz($value)
 * @method static Builder|Qua00l1 wherePropro($value)
 * @method static Builder|Qua00l1 wherePrvdat($value)
 * @method static Builder|Qua00l1 wherePrvnum($value)
 * @method static Builder|Qua00l1 wherePrvtip($value)
 * @method static Builder|Qua00l1 whereQuaann($value)
 * @method static Builder|Qua00l1 whereQual($value)
 * @method static Builder|Qua00l1 whereQuanz($value)
 * @method static Builder|Qua00l1 whereQudal($value)
 * @method static Builder|Qua00l1 whereRapp($value)
 * @method static Builder|Qua00l1 whereRuolo($value)
 * @method static Builder|Qua00l1 whereSapp($value)
 * @method static Builder|Qua00l1 whereServiz($value)
 * @method static Builder|Qua00l1 whereSipco($value)
 * @method static Builder|Qua00l1 whereSodqua($value)
 * @method static Builder|Qua00l1 whereSosfun($value)
 * @method static Builder|Qua00l1 whereSropro($value)
 * @method static Builder|Qua00l1 whereSuolo($value)
 * @method static Builder|Qua00l1 whereTipco($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua00l1 extends BaseModel
{
    protected $table = 'qua00l1';
}
