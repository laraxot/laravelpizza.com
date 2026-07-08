<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua00k2.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $cont
 * @property int|null $matr
 * @property int|null $tipco
 * @property int|null $rapp
 * @property int|null $ruolo
 * @property int|null $propro
 * @property int|null $posfun
 * @property int|null $codqua
 * @property int|null $qudal
 * @property int|null $qual
 * @property int|null $quanz
 * @property int|null $posiz
 * @property int|null $sipco
 * @property int|null $sapp
 * @property int|null $suolo
 * @property int|null $sropro
 * @property int|null $sosfun
 * @property int|null $sodqua
 * @property int|null $annise
 * @property int|null $prvtip
 * @property int|null $prvdat
 * @property string|null $prvnum
 * @property int|null $datpas
 * @property string|null $serviz
 * @property int|null $disci1
 * @property int|null $disci2
 * @property string|null $oree
 * @property string|null $oret
 * @property int|null $aapens
 * @property string|null $quaann
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property int|null $qua2kz
 * @property int|null $prv2kd
 * @property int|null $dat2kp
 * @property int|null $qua001
 * @property string|null $qua002
 * @property string|null $qua003
 * @property int|null $qua004
 * @property int|null $qua005
 *
 * @method static Builder|Qua00k2 newModelQuery()
 * @method static Builder|Qua00k2 newQuery()
 * @method static Builder|Qua00k2 query()
 * @method static Builder|Qua00k2 whereAapens($value)
 * @method static Builder|Qua00k2 whereAnnise($value)
 * @method static Builder|Qua00k2 whereCodqua($value)
 * @method static Builder|Qua00k2 whereCont($value)
 * @method static Builder|Qua00k2 whereDat2kp($value)
 * @method static Builder|Qua00k2 whereDatpas($value)
 * @method static Builder|Qua00k2 whereDisci1($value)
 * @method static Builder|Qua00k2 whereDisci2($value)
 * @method static Builder|Qua00k2 whereEnte($value)
 * @method static Builder|Qua00k2 whereId($value)
 * @method static Builder|Qua00k2 whereMatr($value)
 * @method static Builder|Qua00k2 whereOree($value)
 * @method static Builder|Qua00k2 whereOret($value)
 * @method static Builder|Qua00k2 wherePosfun($value)
 * @method static Builder|Qua00k2 wherePosiz($value)
 * @method static Builder|Qua00k2 wherePropro($value)
 * @method static Builder|Qua00k2 wherePrv2kd($value)
 * @method static Builder|Qua00k2 wherePrvdat($value)
 * @method static Builder|Qua00k2 wherePrvnum($value)
 * @method static Builder|Qua00k2 wherePrvtip($value)
 * @method static Builder|Qua00k2 whereQua001($value)
 * @method static Builder|Qua00k2 whereQua002($value)
 * @method static Builder|Qua00k2 whereQua003($value)
 * @method static Builder|Qua00k2 whereQua004($value)
 * @method static Builder|Qua00k2 whereQua005($value)
 * @method static Builder|Qua00k2 whereQua2ka($value)
 * @method static Builder|Qua00k2 whereQua2kd($value)
 * @method static Builder|Qua00k2 whereQua2kz($value)
 * @method static Builder|Qua00k2 whereQuaann($value)
 * @method static Builder|Qua00k2 whereQual($value)
 * @method static Builder|Qua00k2 whereQuanz($value)
 * @method static Builder|Qua00k2 whereQudal($value)
 * @method static Builder|Qua00k2 whereRapp($value)
 * @method static Builder|Qua00k2 whereRuolo($value)
 * @method static Builder|Qua00k2 whereSapp($value)
 * @method static Builder|Qua00k2 whereServiz($value)
 * @method static Builder|Qua00k2 whereSipco($value)
 * @method static Builder|Qua00k2 whereSodqua($value)
 * @method static Builder|Qua00k2 whereSosfun($value)
 * @method static Builder|Qua00k2 whereSropro($value)
 * @method static Builder|Qua00k2 whereSuolo($value)
 * @method static Builder|Qua00k2 whereTipco($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua00k2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua00k2 extends BaseModel
{
    protected $table = 'qua00k2';
}
