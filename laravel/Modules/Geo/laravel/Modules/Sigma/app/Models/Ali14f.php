<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ali14f.
 *
 * @property int $id
 * @property string|null $flag
 * @property string|null $flagd
 * @property string|null $iarec
 * @property string|null $iarecd
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
 * @property string|null $dtasn
 * @property string|null $numass
 * @property string|null $dtces
 * @property string|null $dtcet
 * @property string|null $dimcau
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
 * @property string|null $xarea
 * @property string|null $xstab
 * @property string|null $xrepa
 * @property string|null $xdesar
 * @property string|null $xdesst
 * @property string|null $xdesre
 * @property string|null $codra
 * @property string|null $codrad
 * @property string|null $idcam
 * @property string|null $idcamd
 * @property string|null $con11
 * @property string|null $tip11
 * @property string|null $rap11
 * @property string|null $ruo11
 * @property string|null $pro11
 * @property string|null $pos11
 * @property string|null $cod11
 * @property string|null $liv11
 * @property string|null $fas11
 * @property string|null $ore11
 * @property string|null $ort11
 * @property string|null $qua11
 * @property string|null $psz11
 * @property string|null $dst11
 * @property string|null $rapd11
 * @property string|null $desc11
 * @property string|null $desc21
 * @property string|null $are11
 * @property string|null $sta11
 * @property string|null $rep11
 * @property string|null $desa11
 * @property string|null $dess11
 * @property string|null $desr11
 * @property string|null $cont
 * @property string|null $tipco
 * @property string|null $rapp
 * @property string|null $ruolo
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $codqua
 * @property string|null $liv
 * @property string|null $fascia
 * @property string|null $oree
 * @property string|null $oret
 * @property string|null $qua005
 * @property string|null $posiz
 * @property string|null $dstem
 * @property string|null $rapdes
 * @property string|null $desc1
 * @property string|null $desc2
 * @property string|null $area
 * @property string|null $stab
 * @property string|null $repa
 * @property string|null $desar
 * @property string|null $desst
 * @property string|null $desre
 * @property string|null $idcont
 * @property string|null $idtipc
 * @property string|null $idrapp
 * @property string|null $idruol
 * @property string|null $idpro
 * @property string|null $idpos
 * @property string|null $idcoq
 * @property string|null $idcat
 * @property string|null $idfas
 * @property string|null $idore
 * @property string|null $idort
 * @property string|null $idpsz
 * @property string|null $idstem
 * @property string|null $irapde
 * @property string|null $idespr
 * @property string|null $idesco
 * @property string|null $idesdi
 * @property string|null $iarea
 * @property string|null $istab
 * @property string|null $irepa
 * @property string|null $idesar
 * @property string|null $idesst
 * @property string|null $idesse
 * @property string|null $idcatp
 * @property string|null $idenlo
 * @property string|null $idlib1
 * @property string|null $idlib2
 * @property string|null $idlib3
 * @property string|null $idlib4
 * @property string|null $datarp
 * @property string|null $datara
 * @property string|null $ruolop
 * @property string|null $arec
 * @property string|null $vpnc
 * @property string|null $lib1
 * @property string|null $lib2
 * @property string|null $lib3
 * @property string|null $lib4
 * @property string|null $lib5
 * @property string|null $lib6
 * @property string|null $lib7
 *
 * @method static Builder|Ali14f newModelQuery()
 * @method static Builder|Ali14f newQuery()
 * @method static Builder|Ali14f query()
 * @method static Builder|Ali14f whereAre11($value)
 * @method static Builder|Ali14f whereArea($value)
 * @method static Builder|Ali14f whereArec($value)
 * @method static Builder|Ali14f whereAsscau($value)
 * @method static Builder|Ali14f whereCod11($value)
 * @method static Builder|Ali14f whereCodfis($value)
 * @method static Builder|Ali14f whereCodqua($value)
 * @method static Builder|Ali14f whereCodra($value)
 * @method static Builder|Ali14f whereCodrad($value)
 * @method static Builder|Ali14f whereCon11($value)
 * @method static Builder|Ali14f whereConome($value)
 * @method static Builder|Ali14f whereCont($value)
 * @method static Builder|Ali14f whereDatara($value)
 * @method static Builder|Ali14f whereDatarp($value)
 * @method static Builder|Ali14f whereDatn1($value)
 * @method static Builder|Ali14f whereDesa11($value)
 * @method static Builder|Ali14f whereDesar($value)
 * @method static Builder|Ali14f whereDesc1($value)
 * @method static Builder|Ali14f whereDesc11($value)
 * @method static Builder|Ali14f whereDesc2($value)
 * @method static Builder|Ali14f whereDesc21($value)
 * @method static Builder|Ali14f whereDesr11($value)
 * @method static Builder|Ali14f whereDesre($value)
 * @method static Builder|Ali14f whereDess11($value)
 * @method static Builder|Ali14f whereDesst($value)
 * @method static Builder|Ali14f whereDimcau($value)
 * @method static Builder|Ali14f whereDst11($value)
 * @method static Builder|Ali14f whereDstem($value)
 * @method static Builder|Ali14f whereDtasn($value)
 * @method static Builder|Ali14f whereDtass($value)
 * @method static Builder|Ali14f whereDtast($value)
 * @method static Builder|Ali14f whereDtces($value)
 * @method static Builder|Ali14f whereDtcet($value)
 * @method static Builder|Ali14f whereEnte($value)
 * @method static Builder|Ali14f whereFas11($value)
 * @method static Builder|Ali14f whereFascia($value)
 * @method static Builder|Ali14f whereFlag($value)
 * @method static Builder|Ali14f whereFlagd($value)
 * @method static Builder|Ali14f whereIarea($value)
 * @method static Builder|Ali14f whereIarec($value)
 * @method static Builder|Ali14f whereIarecd($value)
 * @method static Builder|Ali14f whereId($value)
 * @method static Builder|Ali14f whereIdcam($value)
 * @method static Builder|Ali14f whereIdcamd($value)
 * @method static Builder|Ali14f whereIdcat($value)
 * @method static Builder|Ali14f whereIdcatp($value)
 * @method static Builder|Ali14f whereIdcont($value)
 * @method static Builder|Ali14f whereIdcoq($value)
 * @method static Builder|Ali14f whereIdenlo($value)
 * @method static Builder|Ali14f whereIdesar($value)
 * @method static Builder|Ali14f whereIdesco($value)
 * @method static Builder|Ali14f whereIdesdi($value)
 * @method static Builder|Ali14f whereIdespr($value)
 * @method static Builder|Ali14f whereIdesse($value)
 * @method static Builder|Ali14f whereIdesst($value)
 * @method static Builder|Ali14f whereIdfas($value)
 * @method static Builder|Ali14f whereIdlib1($value)
 * @method static Builder|Ali14f whereIdlib2($value)
 * @method static Builder|Ali14f whereIdlib3($value)
 * @method static Builder|Ali14f whereIdlib4($value)
 * @method static Builder|Ali14f whereIdore($value)
 * @method static Builder|Ali14f whereIdort($value)
 * @method static Builder|Ali14f whereIdpos($value)
 * @method static Builder|Ali14f whereIdpro($value)
 * @method static Builder|Ali14f whereIdpsz($value)
 * @method static Builder|Ali14f whereIdrapp($value)
 * @method static Builder|Ali14f whereIdruol($value)
 * @method static Builder|Ali14f whereIdstem($value)
 * @method static Builder|Ali14f whereIdtipc($value)
 * @method static Builder|Ali14f whereIrapde($value)
 * @method static Builder|Ali14f whereIrepa($value)
 * @method static Builder|Ali14f whereIstab($value)
 * @method static Builder|Ali14f whereLib1($value)
 * @method static Builder|Ali14f whereLib2($value)
 * @method static Builder|Ali14f whereLib3($value)
 * @method static Builder|Ali14f whereLib4($value)
 * @method static Builder|Ali14f whereLib5($value)
 * @method static Builder|Ali14f whereLib6($value)
 * @method static Builder|Ali14f whereLib7($value)
 * @method static Builder|Ali14f whereLiv($value)
 * @method static Builder|Ali14f whereLiv11($value)
 * @method static Builder|Ali14f whereMatr($value)
 * @method static Builder|Ali14f whereNome($value)
 * @method static Builder|Ali14f whereNumass($value)
 * @method static Builder|Ali14f whereOre11($value)
 * @method static Builder|Ali14f whereOree($value)
 * @method static Builder|Ali14f whereOret($value)
 * @method static Builder|Ali14f whereOrt11($value)
 * @method static Builder|Ali14f wherePos11($value)
 * @method static Builder|Ali14f wherePosfun($value)
 * @method static Builder|Ali14f wherePosiz($value)
 * @method static Builder|Ali14f wherePro11($value)
 * @method static Builder|Ali14f wherePropro($value)
 * @method static Builder|Ali14f wherePsz11($value)
 * @method static Builder|Ali14f whereQua005($value)
 * @method static Builder|Ali14f whereQua11($value)
 * @method static Builder|Ali14f whereRap11($value)
 * @method static Builder|Ali14f whereRapd11($value)
 * @method static Builder|Ali14f whereRapdes($value)
 * @method static Builder|Ali14f whereRapp($value)
 * @method static Builder|Ali14f whereRep11($value)
 * @method static Builder|Ali14f whereRepa($value)
 * @method static Builder|Ali14f whereRuo11($value)
 * @method static Builder|Ali14f whereRuolo($value)
 * @method static Builder|Ali14f whereRuolop($value)
 * @method static Builder|Ali14f whereSess1($value)
 * @method static Builder|Ali14f whereSta11($value)
 * @method static Builder|Ali14f whereStab($value)
 * @method static Builder|Ali14f whereTip11($value)
 * @method static Builder|Ali14f whereTipco($value)
 * @method static Builder|Ali14f whereVpnc($value)
 * @method static Builder|Ali14f whereXapdes($value)
 * @method static Builder|Ali14f whereXarea($value)
 * @method static Builder|Ali14f whereXdcat($value)
 * @method static Builder|Ali14f whereXdcont($value)
 * @method static Builder|Ali14f whereXdcoq($value)
 * @method static Builder|Ali14f whereXdesar($value)
 * @method static Builder|Ali14f whereXdesre($value)
 * @method static Builder|Ali14f whereXdesst($value)
 * @method static Builder|Ali14f whereXdfas($value)
 * @method static Builder|Ali14f whereXdore($value)
 * @method static Builder|Ali14f whereXdort($value)
 * @method static Builder|Ali14f whereXdpos($value)
 * @method static Builder|Ali14f whereXdpro($value)
 * @method static Builder|Ali14f whereXdpsz($value)
 * @method static Builder|Ali14f whereXdrapp($value)
 * @method static Builder|Ali14f whereXdruol($value)
 * @method static Builder|Ali14f whereXdstem($value)
 * @method static Builder|Ali14f whereXdtipc($value)
 * @method static Builder|Ali14f whereXespr($value)
 * @method static Builder|Ali14f whereXflag($value)
 * @method static Builder|Ali14f whereXrepa($value)
 * @method static Builder|Ali14f whereXstab($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ali14fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ali14f extends BaseModel
{
    protected $table = 'ali14f';
}
