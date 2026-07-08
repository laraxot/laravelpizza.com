<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua00k3.
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
 * @property string|null $qua2kd
 * @property string|null $qua2ka
 * @property string|null $qua2kz
 * @property string|null $prv2kd
 * @property string|null $dat2kp
 * @property string|null $qua001
 * @property string|null $qua002
 * @property string|null $qua003
 * @property string|null $qua004
 * @property string|null $qua005
 *
 * @method static Builder|Qua00k3 newModelQuery()
 * @method static Builder|Qua00k3 newQuery()
 * @method static Builder|Qua00k3 query()
 * @method static Builder|Qua00k3 whereAapens($value)
 * @method static Builder|Qua00k3 whereAnnise($value)
 * @method static Builder|Qua00k3 whereCodqua($value)
 * @method static Builder|Qua00k3 whereCont($value)
 * @method static Builder|Qua00k3 whereDat2kp($value)
 * @method static Builder|Qua00k3 whereDatpas($value)
 * @method static Builder|Qua00k3 whereDisci1($value)
 * @method static Builder|Qua00k3 whereDisci2($value)
 * @method static Builder|Qua00k3 whereEnte($value)
 * @method static Builder|Qua00k3 whereId($value)
 * @method static Builder|Qua00k3 whereMatr($value)
 * @method static Builder|Qua00k3 whereOree($value)
 * @method static Builder|Qua00k3 whereOret($value)
 * @method static Builder|Qua00k3 wherePosfun($value)
 * @method static Builder|Qua00k3 wherePosiz($value)
 * @method static Builder|Qua00k3 wherePropro($value)
 * @method static Builder|Qua00k3 wherePrv2kd($value)
 * @method static Builder|Qua00k3 wherePrvdat($value)
 * @method static Builder|Qua00k3 wherePrvnum($value)
 * @method static Builder|Qua00k3 wherePrvtip($value)
 * @method static Builder|Qua00k3 whereQua001($value)
 * @method static Builder|Qua00k3 whereQua002($value)
 * @method static Builder|Qua00k3 whereQua003($value)
 * @method static Builder|Qua00k3 whereQua004($value)
 * @method static Builder|Qua00k3 whereQua005($value)
 * @method static Builder|Qua00k3 whereQua2ka($value)
 * @method static Builder|Qua00k3 whereQua2kd($value)
 * @method static Builder|Qua00k3 whereQua2kz($value)
 * @method static Builder|Qua00k3 whereQuaann($value)
 * @method static Builder|Qua00k3 whereQual($value)
 * @method static Builder|Qua00k3 whereQuanz($value)
 * @method static Builder|Qua00k3 whereQudal($value)
 * @method static Builder|Qua00k3 whereRapp($value)
 * @method static Builder|Qua00k3 whereRuolo($value)
 * @method static Builder|Qua00k3 whereSapp($value)
 * @method static Builder|Qua00k3 whereServiz($value)
 * @method static Builder|Qua00k3 whereSipco($value)
 * @method static Builder|Qua00k3 whereSodqua($value)
 * @method static Builder|Qua00k3 whereSosfun($value)
 * @method static Builder|Qua00k3 whereSropro($value)
 * @method static Builder|Qua00k3 whereSuolo($value)
 * @method static Builder|Qua00k3 whereTipco($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua00k3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua00k3 extends BaseModel
{
    protected $table = 'qua00k3';
}
