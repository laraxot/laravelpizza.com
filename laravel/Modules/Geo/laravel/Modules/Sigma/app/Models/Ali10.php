<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ali10.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $assu1
 * @property string|null $dimi1
 * @property string|null $stab
 * @property string|null $repa
 * @property string|null $desst
 * @property string|null $desre
 * @property string|null $datn1
 * @property string|null $eta
 * @property string|null $sess1
 * @property string|null $codf11
 * @property string|null $gru1
 * @property string|null $con1
 * @property string|null $tip1
 * @property string|null $rap1
 * @property string|null $ruo1
 * @property string|null $pro1
 * @property string|null $pos1
 * @property string|null $posf2
 * @property string|null $man1
 * @property string|null $dis1
 * @property string|null $qu1d
 * @property string|null $qu2d
 * @property string|null $qu3d
 * @property string|null $quli
 * @property string|null $fasc1
 * @property string|null $dstem
 * @property string|null $pt1
 * @property string|null $pt2
 * @property string|null $poo
 * @property string|null $datpr1
 * @property string|null $dmie
 * @property string|null $dmief
 * @property string|null $equip
 * @property string|null $seqxx
 * @property string|null $seqyy
 *
 * @method static Builder|Ali10 newModelQuery()
 * @method static Builder|Ali10 newQuery()
 * @method static Builder|Ali10 query()
 * @method static Builder|Ali10 whereAssu1($value)
 * @method static Builder|Ali10 whereCodf11($value)
 * @method static Builder|Ali10 whereCon1($value)
 * @method static Builder|Ali10 whereConome($value)
 * @method static Builder|Ali10 whereDatn1($value)
 * @method static Builder|Ali10 whereDatpr1($value)
 * @method static Builder|Ali10 whereDesre($value)
 * @method static Builder|Ali10 whereDesst($value)
 * @method static Builder|Ali10 whereDimi1($value)
 * @method static Builder|Ali10 whereDis1($value)
 * @method static Builder|Ali10 whereDmie($value)
 * @method static Builder|Ali10 whereDmief($value)
 * @method static Builder|Ali10 whereDstem($value)
 * @method static Builder|Ali10 whereEnte($value)
 * @method static Builder|Ali10 whereEquip($value)
 * @method static Builder|Ali10 whereEta($value)
 * @method static Builder|Ali10 whereFasc1($value)
 * @method static Builder|Ali10 whereGru1($value)
 * @method static Builder|Ali10 whereId($value)
 * @method static Builder|Ali10 whereMan1($value)
 * @method static Builder|Ali10 whereMatr($value)
 * @method static Builder|Ali10 whereNome($value)
 * @method static Builder|Ali10 wherePoo($value)
 * @method static Builder|Ali10 wherePos1($value)
 * @method static Builder|Ali10 wherePosf2($value)
 * @method static Builder|Ali10 wherePro1($value)
 * @method static Builder|Ali10 wherePt1($value)
 * @method static Builder|Ali10 wherePt2($value)
 * @method static Builder|Ali10 whereQu1d($value)
 * @method static Builder|Ali10 whereQu2d($value)
 * @method static Builder|Ali10 whereQu3d($value)
 * @method static Builder|Ali10 whereQuli($value)
 * @method static Builder|Ali10 whereRap1($value)
 * @method static Builder|Ali10 whereRepa($value)
 * @method static Builder|Ali10 whereRuo1($value)
 * @method static Builder|Ali10 whereSeqxx($value)
 * @method static Builder|Ali10 whereSeqyy($value)
 * @method static Builder|Ali10 whereSess1($value)
 * @method static Builder|Ali10 whereStab($value)
 * @method static Builder|Ali10 whereTip1($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ali10Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ali10 extends BaseModel
{
    protected $table = 'ali10';
}
