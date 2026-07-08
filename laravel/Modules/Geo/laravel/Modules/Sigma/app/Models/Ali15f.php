<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ali15f.
 *
 * @property int $id
 * @property string|null $step
 * @property string|null $stepd
 * @property string|null $codra
 * @property string|null $codrad
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $datn1
 * @property string|null $sess1
 * @property string|null $codfis
 * @property string|null $dtass
 * @property string|null $dtast
 * @property string|null $asscau
 * @property string|null $numas
 * @property string|null $dtces
 * @property string|null $dtcet
 * @property string|null $dimcau
 * @property string|null $numce
 * @property string|null $xdcont
 * @property string|null $xdtipc
 * @property string|null $xdrapp
 * @property string|null $xdruol
 * @property string|null $xdpro
 * @property string|null $xdpos
 * @property string|null $xdcoq
 * @property string|null $xdcat
 * @property string|null $xdfas
 * @property string|null $xdore
 * @property string|null $xdort
 * @property string|null $xdpsz
 * @property string|null $xdstem
 * @property string|null $xapdes
 * @property string|null $xespr
 * @property string|null $xflag
 * @property string|null $xdes1
 * @property string|null $xdes2
 * @property string|null $xdes3
 * @property string|null $arec
 * @property string|null $idcam
 * @property string|null $idcamd
 * @property string|null $idlib3
 * @property string|null $lib1
 * @property string|null $lib2
 * @property string|null $lib3
 * @property string|null $lib4
 * @property string|null $lib5
 * @property string|null $lib6
 * @property string|null $lib7
 *
 * @method static Builder|Ali15f newModelQuery()
 * @method static Builder|Ali15f newQuery()
 * @method static Builder|Ali15f query()
 * @method static Builder|Ali15f whereArec($value)
 * @method static Builder|Ali15f whereAsscau($value)
 * @method static Builder|Ali15f whereCodfis($value)
 * @method static Builder|Ali15f whereCodra($value)
 * @method static Builder|Ali15f whereCodrad($value)
 * @method static Builder|Ali15f whereConome($value)
 * @method static Builder|Ali15f whereDatn1($value)
 * @method static Builder|Ali15f whereDimcau($value)
 * @method static Builder|Ali15f whereDtass($value)
 * @method static Builder|Ali15f whereDtast($value)
 * @method static Builder|Ali15f whereDtces($value)
 * @method static Builder|Ali15f whereDtcet($value)
 * @method static Builder|Ali15f whereEnte($value)
 * @method static Builder|Ali15f whereId($value)
 * @method static Builder|Ali15f whereIdcam($value)
 * @method static Builder|Ali15f whereIdcamd($value)
 * @method static Builder|Ali15f whereIdlib3($value)
 * @method static Builder|Ali15f whereLib1($value)
 * @method static Builder|Ali15f whereLib2($value)
 * @method static Builder|Ali15f whereLib3($value)
 * @method static Builder|Ali15f whereLib4($value)
 * @method static Builder|Ali15f whereLib5($value)
 * @method static Builder|Ali15f whereLib6($value)
 * @method static Builder|Ali15f whereLib7($value)
 * @method static Builder|Ali15f whereMatr($value)
 * @method static Builder|Ali15f whereNome($value)
 * @method static Builder|Ali15f whereNumas($value)
 * @method static Builder|Ali15f whereNumce($value)
 * @method static Builder|Ali15f whereSess1($value)
 * @method static Builder|Ali15f whereStep($value)
 * @method static Builder|Ali15f whereStepd($value)
 * @method static Builder|Ali15f whereXapdes($value)
 * @method static Builder|Ali15f whereXdcat($value)
 * @method static Builder|Ali15f whereXdcont($value)
 * @method static Builder|Ali15f whereXdcoq($value)
 * @method static Builder|Ali15f whereXdes1($value)
 * @method static Builder|Ali15f whereXdes2($value)
 * @method static Builder|Ali15f whereXdes3($value)
 * @method static Builder|Ali15f whereXdfas($value)
 * @method static Builder|Ali15f whereXdore($value)
 * @method static Builder|Ali15f whereXdort($value)
 * @method static Builder|Ali15f whereXdpos($value)
 * @method static Builder|Ali15f whereXdpro($value)
 * @method static Builder|Ali15f whereXdpsz($value)
 * @method static Builder|Ali15f whereXdrapp($value)
 * @method static Builder|Ali15f whereXdruol($value)
 * @method static Builder|Ali15f whereXdstem($value)
 * @method static Builder|Ali15f whereXdtipc($value)
 * @method static Builder|Ali15f whereXespr($value)
 * @method static Builder|Ali15f whereXflag($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ali15fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ali15f extends BaseModel
{
    protected $table = 'ali15f';
}
