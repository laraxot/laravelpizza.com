<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Acco4f.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $datces
 * @property string $tipoce
 * @property string $con92
 * @property string $conces
 * @property int $datpre
 * @property int $datapp
 * @property string $per92
 * @property string $ris92
 * @property string $ric92
 * @property string $per93
 * @property string $ris93
 * @property string $ric93
 * @property string $per95
 * @property string $ris95
 * @property string $ric95
 * @property string $ret93
 * @property string $riv93
 * @property string $med93
 * @property int $aadura
 * @property int $mmdura
 * @property int $ggdura
 * @property int $audura
 * @property int $mudura
 * @property int $gudura
 * @property int $aardur
 * @property int $mardur
 * @property int $aaut92
 * @property int $mmut92
 * @property int $ggut92
 * @property int $aaar92
 * @property int $mmar92
 * @property int $anzr92
 * @property int $aa92ar
 * @property int $aama92
 * @property string $cost92
 * @property int $aman92
 * @property int $mman92
 * @property int $gman92
 * @property int $aric92
 * @property int $mric92
 * @property int $gric92
 * @property int $mang92
 * @property int $manm92
 * @property int $mana92
 * @property int $gmat92
 * @property int $mmat92
 * @property int $amat92
 * @property int $gacc92
 * @property int $macc92
 * @property int $aacc92
 * @property int $aadu93
 * @property int $mmdu93
 * @property int $ggdu93
 * @property int $audu93
 * @property int $mudu93
 * @property int $gudu93
 * @property int $aard93
 * @property int $mard93
 * @property int $aaut93
 * @property int $mmut93
 * @property int $ggut93
 * @property int $aaar93
 * @property int $mmar93
 * @property int $aadu95
 * @property int $mmdu95
 * @property int $ggdu95
 * @property int $audu95
 * @property int $mudu95
 * @property int $gudu95
 * @property int $aard95
 * @property int $mard95
 * @property int $aaut95
 * @property int $mmut95
 * @property int $ggut95
 * @property int $aaar95
 * @property int $mmar95
 * @property int $aaut94
 * @property int $mmut94
 * @property int $ggut94
 * @property int $aaar94
 * @property int $mmar94
 * @property int $aatuti
 * @property int $mmtuti
 * @property int $ggtuti
 * @property int $aatarr
 * @property int $mmtarr
 * @property int $anztot
 * @property string $cof92
 * @property string $cof94
 * @property string $cof95
 * @property string $coftot
 * @property int $arroaa
 * @property int $arromm
 * @property string $totcof
 * @property int $ar92aa
 * @property int $ar92mm
 * @property string $cof92a
 * @property int $aarife
 * @property int $mmrife
 * @property int $mesiri
 * @property string $difcof
 * @property int $rifeme
 * @property int $mang93
 * @property int $manm93
 * @property int $mana93
 * @property int $gman93
 * @property int $mman93
 * @property int $aman93
 * @property int $gmat93
 * @property int $mmat93
 * @property int $amat93
 * @property int $gacc93
 * @property int $macc93
 * @property int $aacc93
 * @property int $inizp
 * @property int $finep
 * @property int $pendec
 * @property int $pede93
 * @property int $giorif
 * @property int $giori2
 * @property string $coeffe
 * @property int $tgirif
 * @property int $tgival
 * @property int $torriv
 * @property int $torcon
 * @property int $rmariv
 * @property int $rmacon
 * @property int $reet80
 * @property int $decpen
 * @property int $depe93
 * @property int $rp92
 * @property string $cf92
 * @property int $pa92
 * @property int $rm93
 * @property string $cf93
 * @property int $pm93
 * @property int $pa93
 * @property int $pa95
 * @property int $pa93a
 * @property int $rl336
 * @property string $cfl336
 * @property int $pl336
 * @property int $pannc
 * @property int $aal537
 * @property int $ral537
 * @property int $pannl
 * @property int $pmenc
 * @property int $pmenl
 * @property int $pmenll
 * @property int $ssnmen
 * @property int $irpnet
 * @property int $pennet
 * @property int $irpimp
 * @property int $irplor
 * @property int $detfis
 * @property int $dvar1
 * @property int $rmaco2
 * @property int $impmax
 * @property int $aapedu
 * @property int $mmpedu
 * @property int $ggpedu
 * @property int $aapeut
 * @property int $mmpeut
 * @property int $ggpeut
 * @property int $aapear
 * @property int $mmpear
 * @property int $aariut
 * @property int $mmriut
 * @property int $ggriut
 * @property int $aariar
 * @property int $mmriar
 * @property int $aarcut
 * @property int $mmrcut
 * @property int $ggrcut
 * @property int $aarcar
 * @property int $mmrcar
 * @property int $rever
 * @property int $costan
 * @property int $panind
 * @property int $pannc2
 * @property int $pannc3
 * @property int $pannc4
 * @property int $risric
 * @property int $annri4
 * @property int $mesri4
 * @property int $giori4
 * @property int $annri2
 * @property int $mesri2
 * @property int $gma92
 * @property int $mma92
 * @property int $ama92
 * @property int $netpen
 * @property int $assfam
 * @property string $retflg
 * @property int $mes50i
 * @property int $mes50r
 * @property int $mes66i
 * @property int $mes66r
 * @property string $tipo9
 * @property string $risarr
 * @property string $risa93
 * @property string $risa95
 * @property string $ridman
 * @property int $riduzi
 * @property int $riduz2
 * @property string $access
 * @property int $gio50i
 * @property int $gio50r
 * @property int $gio66i
 * @property int $gio66r
 * @property string $sino19
 *
 * @method static Builder|Acco4f newModelQuery()
 * @method static Builder|Acco4f newQuery()
 * @method static Builder|Acco4f query()
 * @method static Builder|Acco4f whereAa92ar($value)
 * @method static Builder|Acco4f whereAaar92($value)
 * @method static Builder|Acco4f whereAaar93($value)
 * @method static Builder|Acco4f whereAaar94($value)
 * @method static Builder|Acco4f whereAaar95($value)
 * @method static Builder|Acco4f whereAacc92($value)
 * @method static Builder|Acco4f whereAacc93($value)
 * @method static Builder|Acco4f whereAadu93($value)
 * @method static Builder|Acco4f whereAadu95($value)
 * @method static Builder|Acco4f whereAadura($value)
 * @method static Builder|Acco4f whereAal537($value)
 * @method static Builder|Acco4f whereAama92($value)
 * @method static Builder|Acco4f whereAapear($value)
 * @method static Builder|Acco4f whereAapedu($value)
 * @method static Builder|Acco4f whereAapeut($value)
 * @method static Builder|Acco4f whereAarcar($value)
 * @method static Builder|Acco4f whereAarcut($value)
 * @method static Builder|Acco4f whereAard93($value)
 * @method static Builder|Acco4f whereAard95($value)
 * @method static Builder|Acco4f whereAardur($value)
 * @method static Builder|Acco4f whereAariar($value)
 * @method static Builder|Acco4f whereAarife($value)
 * @method static Builder|Acco4f whereAariut($value)
 * @method static Builder|Acco4f whereAatarr($value)
 * @method static Builder|Acco4f whereAatuti($value)
 * @method static Builder|Acco4f whereAaut92($value)
 * @method static Builder|Acco4f whereAaut93($value)
 * @method static Builder|Acco4f whereAaut94($value)
 * @method static Builder|Acco4f whereAaut95($value)
 * @method static Builder|Acco4f whereAccess($value)
 * @method static Builder|Acco4f whereAma92($value)
 * @method static Builder|Acco4f whereAman92($value)
 * @method static Builder|Acco4f whereAman93($value)
 * @method static Builder|Acco4f whereAmat92($value)
 * @method static Builder|Acco4f whereAmat93($value)
 * @method static Builder|Acco4f whereAnnri2($value)
 * @method static Builder|Acco4f whereAnnri4($value)
 * @method static Builder|Acco4f whereAnzr92($value)
 * @method static Builder|Acco4f whereAnztot($value)
 * @method static Builder|Acco4f whereAr92aa($value)
 * @method static Builder|Acco4f whereAr92mm($value)
 * @method static Builder|Acco4f whereAric92($value)
 * @method static Builder|Acco4f whereArroaa($value)
 * @method static Builder|Acco4f whereArromm($value)
 * @method static Builder|Acco4f whereAssfam($value)
 * @method static Builder|Acco4f whereAudu93($value)
 * @method static Builder|Acco4f whereAudu95($value)
 * @method static Builder|Acco4f whereAudura($value)
 * @method static Builder|Acco4f whereCf92($value)
 * @method static Builder|Acco4f whereCf93($value)
 * @method static Builder|Acco4f whereCfl336($value)
 * @method static Builder|Acco4f whereCoeffe($value)
 * @method static Builder|Acco4f whereCof92($value)
 * @method static Builder|Acco4f whereCof92a($value)
 * @method static Builder|Acco4f whereCof94($value)
 * @method static Builder|Acco4f whereCof95($value)
 * @method static Builder|Acco4f whereCoftot($value)
 * @method static Builder|Acco4f whereCon92($value)
 * @method static Builder|Acco4f whereConces($value)
 * @method static Builder|Acco4f whereCost92($value)
 * @method static Builder|Acco4f whereCostan($value)
 * @method static Builder|Acco4f whereDatapp($value)
 * @method static Builder|Acco4f whereDatces($value)
 * @method static Builder|Acco4f whereDatpre($value)
 * @method static Builder|Acco4f whereDecpen($value)
 * @method static Builder|Acco4f whereDepe93($value)
 * @method static Builder|Acco4f whereDetfis($value)
 * @method static Builder|Acco4f whereDifcof($value)
 * @method static Builder|Acco4f whereDvar1($value)
 * @method static Builder|Acco4f whereEnte($value)
 * @method static Builder|Acco4f whereFinep($value)
 * @method static Builder|Acco4f whereGacc92($value)
 * @method static Builder|Acco4f whereGacc93($value)
 * @method static Builder|Acco4f whereGgdu93($value)
 * @method static Builder|Acco4f whereGgdu95($value)
 * @method static Builder|Acco4f whereGgdura($value)
 * @method static Builder|Acco4f whereGgpedu($value)
 * @method static Builder|Acco4f whereGgpeut($value)
 * @method static Builder|Acco4f whereGgrcut($value)
 * @method static Builder|Acco4f whereGgriut($value)
 * @method static Builder|Acco4f whereGgtuti($value)
 * @method static Builder|Acco4f whereGgut92($value)
 * @method static Builder|Acco4f whereGgut93($value)
 * @method static Builder|Acco4f whereGgut94($value)
 * @method static Builder|Acco4f whereGgut95($value)
 * @method static Builder|Acco4f whereGio50i($value)
 * @method static Builder|Acco4f whereGio50r($value)
 * @method static Builder|Acco4f whereGio66i($value)
 * @method static Builder|Acco4f whereGio66r($value)
 * @method static Builder|Acco4f whereGiori2($value)
 * @method static Builder|Acco4f whereGiori4($value)
 * @method static Builder|Acco4f whereGiorif($value)
 * @method static Builder|Acco4f whereGma92($value)
 * @method static Builder|Acco4f whereGman92($value)
 * @method static Builder|Acco4f whereGman93($value)
 * @method static Builder|Acco4f whereGmat92($value)
 * @method static Builder|Acco4f whereGmat93($value)
 * @method static Builder|Acco4f whereGric92($value)
 * @method static Builder|Acco4f whereGudu93($value)
 * @method static Builder|Acco4f whereGudu95($value)
 * @method static Builder|Acco4f whereGudura($value)
 * @method static Builder|Acco4f whereId($value)
 * @method static Builder|Acco4f whereImpmax($value)
 * @method static Builder|Acco4f whereInizp($value)
 * @method static Builder|Acco4f whereIrpimp($value)
 * @method static Builder|Acco4f whereIrplor($value)
 * @method static Builder|Acco4f whereIrpnet($value)
 * @method static Builder|Acco4f whereMacc92($value)
 * @method static Builder|Acco4f whereMacc93($value)
 * @method static Builder|Acco4f whereMana92($value)
 * @method static Builder|Acco4f whereMana93($value)
 * @method static Builder|Acco4f whereMang92($value)
 * @method static Builder|Acco4f whereMang93($value)
 * @method static Builder|Acco4f whereManm92($value)
 * @method static Builder|Acco4f whereManm93($value)
 * @method static Builder|Acco4f whereMard93($value)
 * @method static Builder|Acco4f whereMard95($value)
 * @method static Builder|Acco4f whereMardur($value)
 * @method static Builder|Acco4f whereMatr($value)
 * @method static Builder|Acco4f whereMed93($value)
 * @method static Builder|Acco4f whereMes50i($value)
 * @method static Builder|Acco4f whereMes50r($value)
 * @method static Builder|Acco4f whereMes66i($value)
 * @method static Builder|Acco4f whereMes66r($value)
 * @method static Builder|Acco4f whereMesiri($value)
 * @method static Builder|Acco4f whereMesri2($value)
 * @method static Builder|Acco4f whereMesri4($value)
 * @method static Builder|Acco4f whereMma92($value)
 * @method static Builder|Acco4f whereMman92($value)
 * @method static Builder|Acco4f whereMman93($value)
 * @method static Builder|Acco4f whereMmar92($value)
 * @method static Builder|Acco4f whereMmar93($value)
 * @method static Builder|Acco4f whereMmar94($value)
 * @method static Builder|Acco4f whereMmar95($value)
 * @method static Builder|Acco4f whereMmat92($value)
 * @method static Builder|Acco4f whereMmat93($value)
 * @method static Builder|Acco4f whereMmdu93($value)
 * @method static Builder|Acco4f whereMmdu95($value)
 * @method static Builder|Acco4f whereMmdura($value)
 * @method static Builder|Acco4f whereMmpear($value)
 * @method static Builder|Acco4f whereMmpedu($value)
 * @method static Builder|Acco4f whereMmpeut($value)
 * @method static Builder|Acco4f whereMmrcar($value)
 * @method static Builder|Acco4f whereMmrcut($value)
 * @method static Builder|Acco4f whereMmriar($value)
 * @method static Builder|Acco4f whereMmrife($value)
 * @method static Builder|Acco4f whereMmriut($value)
 * @method static Builder|Acco4f whereMmtarr($value)
 * @method static Builder|Acco4f whereMmtuti($value)
 * @method static Builder|Acco4f whereMmut92($value)
 * @method static Builder|Acco4f whereMmut93($value)
 * @method static Builder|Acco4f whereMmut94($value)
 * @method static Builder|Acco4f whereMmut95($value)
 * @method static Builder|Acco4f whereMric92($value)
 * @method static Builder|Acco4f whereMudu93($value)
 * @method static Builder|Acco4f whereMudu95($value)
 * @method static Builder|Acco4f whereMudura($value)
 * @method static Builder|Acco4f whereNetpen($value)
 * @method static Builder|Acco4f wherePa92($value)
 * @method static Builder|Acco4f wherePa93($value)
 * @method static Builder|Acco4f wherePa93a($value)
 * @method static Builder|Acco4f wherePa95($value)
 * @method static Builder|Acco4f wherePanind($value)
 * @method static Builder|Acco4f wherePannc($value)
 * @method static Builder|Acco4f wherePannc2($value)
 * @method static Builder|Acco4f wherePannc3($value)
 * @method static Builder|Acco4f wherePannc4($value)
 * @method static Builder|Acco4f wherePannl($value)
 * @method static Builder|Acco4f wherePede93($value)
 * @method static Builder|Acco4f wherePendec($value)
 * @method static Builder|Acco4f wherePennet($value)
 * @method static Builder|Acco4f wherePer92($value)
 * @method static Builder|Acco4f wherePer93($value)
 * @method static Builder|Acco4f wherePer95($value)
 * @method static Builder|Acco4f wherePl336($value)
 * @method static Builder|Acco4f wherePm93($value)
 * @method static Builder|Acco4f wherePmenc($value)
 * @method static Builder|Acco4f wherePmenl($value)
 * @method static Builder|Acco4f wherePmenll($value)
 * @method static Builder|Acco4f whereRal537($value)
 * @method static Builder|Acco4f whereReet80($value)
 * @method static Builder|Acco4f whereRet93($value)
 * @method static Builder|Acco4f whereRetflg($value)
 * @method static Builder|Acco4f whereRever($value)
 * @method static Builder|Acco4f whereRic92($value)
 * @method static Builder|Acco4f whereRic93($value)
 * @method static Builder|Acco4f whereRic95($value)
 * @method static Builder|Acco4f whereRidman($value)
 * @method static Builder|Acco4f whereRiduz2($value)
 * @method static Builder|Acco4f whereRiduzi($value)
 * @method static Builder|Acco4f whereRifeme($value)
 * @method static Builder|Acco4f whereRis92($value)
 * @method static Builder|Acco4f whereRis93($value)
 * @method static Builder|Acco4f whereRis95($value)
 * @method static Builder|Acco4f whereRisa93($value)
 * @method static Builder|Acco4f whereRisa95($value)
 * @method static Builder|Acco4f whereRisarr($value)
 * @method static Builder|Acco4f whereRisric($value)
 * @method static Builder|Acco4f whereRiv93($value)
 * @method static Builder|Acco4f whereRl336($value)
 * @method static Builder|Acco4f whereRm93($value)
 * @method static Builder|Acco4f whereRmaco2($value)
 * @method static Builder|Acco4f whereRmacon($value)
 * @method static Builder|Acco4f whereRmariv($value)
 * @method static Builder|Acco4f whereRp92($value)
 * @method static Builder|Acco4f whereSino19($value)
 * @method static Builder|Acco4f whereSsnmen($value)
 * @method static Builder|Acco4f whereTgirif($value)
 * @method static Builder|Acco4f whereTgival($value)
 * @method static Builder|Acco4f whereTipo9($value)
 * @method static Builder|Acco4f whereTipoce($value)
 * @method static Builder|Acco4f whereTorcon($value)
 * @method static Builder|Acco4f whereTorriv($value)
 * @method static Builder|Acco4f whereTotcof($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Acco4fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Acco4f extends BaseModel
{
    protected $table = 'acco4f';
}
