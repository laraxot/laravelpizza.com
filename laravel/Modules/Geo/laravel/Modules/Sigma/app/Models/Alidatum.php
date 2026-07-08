<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Alidatum.
 *
 * @method static Builder|Alidatum newModelQuery()
 * @method static Builder|Alidatum newQuery()
 * @method static Builder|Alidatum query()
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $datn
 * @property string|null $comn
 * @property string|null $codf
 * @property string|null $sess
 * @property string|null $comr
 * @property string|null $pror
 * @property string|null $locr
 * @property string|null $topr
 * @property string|null $viar
 * @property string|null $capr
 * @property string|null $ass
 * @property string|null $dim
 * @property string|null $sta
 * @property string|null $stad
 * @property string|null $rep
 * @property string|null $repd
 * @property string|null $ca1
 * @property string|null $ca1d
 * @property string|null $cb1
 * @property string|null $cb1d
 * @property string|null $cc1
 * @property string|null $cc1d
 * @property string|null $pr1
 * @property string|null $ca2
 * @property string|null $ca2d
 * @property string|null $cb2
 * @property string|null $cb2d
 * @property string|null $cc2
 * @property string|null $cc2d
 * @property string|null $pr2
 * @property string|null $ca3
 * @property string|null $ca3d
 * @property string|null $cb3
 * @property string|null $cb3d
 * @property string|null $cc3
 * @property string|null $cc3d
 * @property string|null $pr3
 * @property string|null $con
 * @property string|null $rap
 * @property string|null $ruo
 * @property string|null $pro
 * @property string|null $pos
 * @property string|null $man
 * @property string|null $dis
 * @property string|null $prod
 * @property string|null $disd
 * @property string|null $qu1d
 * @property string|null $qu2d
 * @property string|null $quli
 * @property string|null $fascia
 * @property string|null $pt1
 * @property string|null $pt2
 * @property string|null $poo
 * @property string|null $pood
 * @property string|null $cat1
 * @property string|null $decat1
 * @property string|null $cat2
 * @property string|null $decat2
 * @property string|null $tit
 * @property string|null $destit
 * @property string|null $ina
 * @property string|null $desina
 * @property string|null $cla
 * @property string|null $descla
 * @property string|null $irap
 * @property string|null $deirap
 * @property string|null $datsca
 * @property string|null $cliv1
 * @property string|null $dliv1
 * @property string|null $cliv2
 * @property string|null $dliv2
 * @property string|null $cliv3
 * @property string|null $dliv3
 * @property string|null $cliv4
 * @property string|null $dliv4
 * @property string|null $cliv5
 * @property string|null $dliv5
 * @property string|null $cliv6
 * @property string|null $dliv6
 * @property string|null $cliv7
 * @property string|null $dliv7
 * @property string|null $cliv8
 * @property string|null $dliv8
 *
 * @method static Builder|Alidatum whereAss($value)
 * @method static Builder|Alidatum whereCa1($value)
 * @method static Builder|Alidatum whereCa1d($value)
 * @method static Builder|Alidatum whereCa2($value)
 * @method static Builder|Alidatum whereCa2d($value)
 * @method static Builder|Alidatum whereCa3($value)
 * @method static Builder|Alidatum whereCa3d($value)
 * @method static Builder|Alidatum whereCapr($value)
 * @method static Builder|Alidatum whereCat1($value)
 * @method static Builder|Alidatum whereCat2($value)
 * @method static Builder|Alidatum whereCb1($value)
 * @method static Builder|Alidatum whereCb1d($value)
 * @method static Builder|Alidatum whereCb2($value)
 * @method static Builder|Alidatum whereCb2d($value)
 * @method static Builder|Alidatum whereCb3($value)
 * @method static Builder|Alidatum whereCb3d($value)
 * @method static Builder|Alidatum whereCc1($value)
 * @method static Builder|Alidatum whereCc1d($value)
 * @method static Builder|Alidatum whereCc2($value)
 * @method static Builder|Alidatum whereCc2d($value)
 * @method static Builder|Alidatum whereCc3($value)
 * @method static Builder|Alidatum whereCc3d($value)
 * @method static Builder|Alidatum whereCla($value)
 * @method static Builder|Alidatum whereCliv1($value)
 * @method static Builder|Alidatum whereCliv2($value)
 * @method static Builder|Alidatum whereCliv3($value)
 * @method static Builder|Alidatum whereCliv4($value)
 * @method static Builder|Alidatum whereCliv5($value)
 * @method static Builder|Alidatum whereCliv6($value)
 * @method static Builder|Alidatum whereCliv7($value)
 * @method static Builder|Alidatum whereCliv8($value)
 * @method static Builder|Alidatum whereCodf($value)
 * @method static Builder|Alidatum whereComn($value)
 * @method static Builder|Alidatum whereComr($value)
 * @method static Builder|Alidatum whereCon($value)
 * @method static Builder|Alidatum whereConome($value)
 * @method static Builder|Alidatum whereDatn($value)
 * @method static Builder|Alidatum whereDatsca($value)
 * @method static Builder|Alidatum whereDecat1($value)
 * @method static Builder|Alidatum whereDecat2($value)
 * @method static Builder|Alidatum whereDeirap($value)
 * @method static Builder|Alidatum whereDescla($value)
 * @method static Builder|Alidatum whereDesina($value)
 * @method static Builder|Alidatum whereDestit($value)
 * @method static Builder|Alidatum whereDim($value)
 * @method static Builder|Alidatum whereDis($value)
 * @method static Builder|Alidatum whereDisd($value)
 * @method static Builder|Alidatum whereDliv1($value)
 * @method static Builder|Alidatum whereDliv2($value)
 * @method static Builder|Alidatum whereDliv3($value)
 * @method static Builder|Alidatum whereDliv4($value)
 * @method static Builder|Alidatum whereDliv5($value)
 * @method static Builder|Alidatum whereDliv6($value)
 * @method static Builder|Alidatum whereDliv7($value)
 * @method static Builder|Alidatum whereDliv8($value)
 * @method static Builder|Alidatum whereEnte($value)
 * @method static Builder|Alidatum whereFascia($value)
 * @method static Builder|Alidatum whereId($value)
 * @method static Builder|Alidatum whereIna($value)
 * @method static Builder|Alidatum whereIrap($value)
 * @method static Builder|Alidatum whereLocr($value)
 * @method static Builder|Alidatum whereMan($value)
 * @method static Builder|Alidatum whereMatr($value)
 * @method static Builder|Alidatum whereNome($value)
 * @method static Builder|Alidatum wherePoo($value)
 * @method static Builder|Alidatum wherePood($value)
 * @method static Builder|Alidatum wherePos($value)
 * @method static Builder|Alidatum wherePr1($value)
 * @method static Builder|Alidatum wherePr2($value)
 * @method static Builder|Alidatum wherePr3($value)
 * @method static Builder|Alidatum wherePro($value)
 * @method static Builder|Alidatum whereProd($value)
 * @method static Builder|Alidatum wherePror($value)
 * @method static Builder|Alidatum wherePt1($value)
 * @method static Builder|Alidatum wherePt2($value)
 * @method static Builder|Alidatum whereQu1d($value)
 * @method static Builder|Alidatum whereQu2d($value)
 * @method static Builder|Alidatum whereQuli($value)
 * @method static Builder|Alidatum whereRap($value)
 * @method static Builder|Alidatum whereRep($value)
 * @method static Builder|Alidatum whereRepd($value)
 * @method static Builder|Alidatum whereRuo($value)
 * @method static Builder|Alidatum whereSess($value)
 * @method static Builder|Alidatum whereSta($value)
 * @method static Builder|Alidatum whereStad($value)
 * @method static Builder|Alidatum whereTit($value)
 * @method static Builder|Alidatum whereTopr($value)
 * @method static Builder|Alidatum whereViar($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AlidatumFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Alidatum extends BaseModel
{
    protected $table = 'alidatum';
}
