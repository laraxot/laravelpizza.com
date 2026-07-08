<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Alipo.
 *
 * @method static Builder|Alipo newModelQuery()
 * @method static Builder|Alipo newQuery()
 * @method static Builder|Alipo query()
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $spdata
 * @property string|null $prou
 * @property string|null $posu
 * @property string|null $codu
 * @property string|null $assu1
 * @property string|null $dimi1
 * @property string|null $cont
 * @property string|null $tipco
 * @property string|null $rapp
 * @property string|null $ruolo
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $codqua
 * @property string|null $disci1
 * @property string|null $desc1
 * @property string|null $desc2
 * @property string|null $descx
 * @property string|null $dsliv
 * @property string|null $dss1x
 * @property string|null $oree
 * @property string|null $oret
 * @property string|null $qua2kp
 * @property string|null $tmf
 * @property string|null $v4110
 * @property string|null $v4410
 * @property string|null $v4400
 * @property string|null $diff
 * @property string|null $flagat
 * @property string|null $flagx
 *
 * @method static Builder|Alipo whereAssu1($value)
 * @method static Builder|Alipo whereCodqua($value)
 * @method static Builder|Alipo whereCodu($value)
 * @method static Builder|Alipo whereConome($value)
 * @method static Builder|Alipo whereCont($value)
 * @method static Builder|Alipo whereDesc1($value)
 * @method static Builder|Alipo whereDesc2($value)
 * @method static Builder|Alipo whereDescx($value)
 * @method static Builder|Alipo whereDiff($value)
 * @method static Builder|Alipo whereDimi1($value)
 * @method static Builder|Alipo whereDisci1($value)
 * @method static Builder|Alipo whereDsliv($value)
 * @method static Builder|Alipo whereDss1x($value)
 * @method static Builder|Alipo whereEnte($value)
 * @method static Builder|Alipo whereFlagat($value)
 * @method static Builder|Alipo whereFlagx($value)
 * @method static Builder|Alipo whereId($value)
 * @method static Builder|Alipo whereMatr($value)
 * @method static Builder|Alipo whereNome($value)
 * @method static Builder|Alipo whereOree($value)
 * @method static Builder|Alipo whereOret($value)
 * @method static Builder|Alipo wherePosfun($value)
 * @method static Builder|Alipo wherePosu($value)
 * @method static Builder|Alipo wherePropro($value)
 * @method static Builder|Alipo whereProu($value)
 * @method static Builder|Alipo whereQua2kp($value)
 * @method static Builder|Alipo whereRapp($value)
 * @method static Builder|Alipo whereRuolo($value)
 * @method static Builder|Alipo whereSpdata($value)
 * @method static Builder|Alipo whereTipco($value)
 * @method static Builder|Alipo whereTmf($value)
 * @method static Builder|Alipo whereV4110($value)
 * @method static Builder|Alipo whereV4400($value)
 * @method static Builder|Alipo whereV4410($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AlipoFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Alipo extends BaseModel
{
    protected $table = 'alipo';
}
