<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Alianz.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $assu1_assunzione
 * @property string|null $dimi1_dimissione
 * @property string|null $stab_stabilimento
 * @property string|null $repa_reparto
 * @property string|null $desst
 * @property string|null $desre
 * @property string|null $datn1_data_nascita
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
 * @property string|null $man1
 * @property string|null $dis1
 * @property string|null $qu1d
 * @property string|null $qu2d
 * @property string|null $qu3d
 * @property string|null $quli
 * @property string|null $pt1
 * @property string|null $pt2
 * @property string|null $poo
 * @property string|null $datpr1
 * @property string|null $gg1c
 * @property string|null $aa1
 * @property string|null $mm1
 * @property string|null $gg1
 * @property string|null $gg1as
 * @property string|null $gg2c
 * @property string|null $aa2
 * @property string|null $mm2
 * @property string|null $gg2
 * @property string|null $gg2as
 * @property string|null $gg3c
 * @property string|null $aa3
 * @property string|null $mm3
 * @property string|null $gg3
 * @property string|null $gg3as
 * @property string|null $gg4c
 * @property string|null $aa4
 * @property string|null $mm4
 * @property string|null $gg4
 * @property string|null $gg5c
 * @property string|null $aa5
 * @property string|null $mm5
 * @property string|null $gg5
 * @property string|null $gg5as
 * @property string|null $gg6c
 * @property string|null $aa6
 * @property string|null $mm6
 * @property string|null $gg6
 * @property string|null $gg6as
 * @property string|null $gg6cco
 * @property string|null $datai2
 * @property string|null $titstu
 * @property string|null $codstu
 * @property string|null $destit
 *
 * @method static Builder|Alianz newModelQuery()
 * @method static Builder|Alianz newQuery()
 * @method static Builder|Alianz query()
 * @method static Builder|Alianz whereAa1($value)
 * @method static Builder|Alianz whereAa2($value)
 * @method static Builder|Alianz whereAa3($value)
 * @method static Builder|Alianz whereAa4($value)
 * @method static Builder|Alianz whereAa5($value)
 * @method static Builder|Alianz whereAa6($value)
 * @method static Builder|Alianz whereAssu1Assunzione($value)
 * @method static Builder|Alianz whereCodf11($value)
 * @method static Builder|Alianz whereCodstu($value)
 * @method static Builder|Alianz whereCon1($value)
 * @method static Builder|Alianz whereConome($value)
 * @method static Builder|Alianz whereDatai2($value)
 * @method static Builder|Alianz whereDatn1DataNascita($value)
 * @method static Builder|Alianz whereDatpr1($value)
 * @method static Builder|Alianz whereDesre($value)
 * @method static Builder|Alianz whereDesst($value)
 * @method static Builder|Alianz whereDestit($value)
 * @method static Builder|Alianz whereDimi1Dimissione($value)
 * @method static Builder|Alianz whereDis1($value)
 * @method static Builder|Alianz whereEnte($value)
 * @method static Builder|Alianz whereEta($value)
 * @method static Builder|Alianz whereGg1($value)
 * @method static Builder|Alianz whereGg1as($value)
 * @method static Builder|Alianz whereGg1c($value)
 * @method static Builder|Alianz whereGg2($value)
 * @method static Builder|Alianz whereGg2as($value)
 * @method static Builder|Alianz whereGg2c($value)
 * @method static Builder|Alianz whereGg3($value)
 * @method static Builder|Alianz whereGg3as($value)
 * @method static Builder|Alianz whereGg3c($value)
 * @method static Builder|Alianz whereGg4($value)
 * @method static Builder|Alianz whereGg4c($value)
 * @method static Builder|Alianz whereGg5($value)
 * @method static Builder|Alianz whereGg5as($value)
 * @method static Builder|Alianz whereGg5c($value)
 * @method static Builder|Alianz whereGg6($value)
 * @method static Builder|Alianz whereGg6as($value)
 * @method static Builder|Alianz whereGg6c($value)
 * @method static Builder|Alianz whereGg6cco($value)
 * @method static Builder|Alianz whereGru1($value)
 * @method static Builder|Alianz whereId($value)
 * @method static Builder|Alianz whereMan1($value)
 * @method static Builder|Alianz whereMatr($value)
 * @method static Builder|Alianz whereMm1($value)
 * @method static Builder|Alianz whereMm2($value)
 * @method static Builder|Alianz whereMm3($value)
 * @method static Builder|Alianz whereMm4($value)
 * @method static Builder|Alianz whereMm5($value)
 * @method static Builder|Alianz whereMm6($value)
 * @method static Builder|Alianz whereNome($value)
 * @method static Builder|Alianz wherePoo($value)
 * @method static Builder|Alianz wherePos1($value)
 * @method static Builder|Alianz wherePro1($value)
 * @method static Builder|Alianz wherePt1($value)
 * @method static Builder|Alianz wherePt2($value)
 * @method static Builder|Alianz whereQu1d($value)
 * @method static Builder|Alianz whereQu2d($value)
 * @method static Builder|Alianz whereQu3d($value)
 * @method static Builder|Alianz whereQuli($value)
 * @method static Builder|Alianz whereRap1($value)
 * @method static Builder|Alianz whereRepaReparto($value)
 * @method static Builder|Alianz whereRuo1($value)
 * @method static Builder|Alianz whereSess1($value)
 * @method static Builder|Alianz whereStabStabilimento($value)
 * @method static Builder|Alianz whereTip1($value)
 * @method static Builder|Alianz whereTitstu($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AlianzFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Alianz extends BaseModel
{
    protected $table = 'alianz';
}
