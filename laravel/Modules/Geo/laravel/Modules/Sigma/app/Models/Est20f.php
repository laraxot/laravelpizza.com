<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est20f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $auto1
 * @property string|null $auto2
 * @property string|null $auto3
 * @property string|null $tarif1
 * @property string|null $tarif2
 * @property string|null $tarif3
 * @property string|null $commi1
 * @property string|null $commi2
 * @property string|null $commi3
 * @property string|null $commi4
 * @property string|null $commi5
 * @property string|null $commi6
 * @property string|null $commi7
 * @property string|null $dal1
 * @property string|null $al1
 * @property string|null $dal2
 * @property string|null $al2
 * @property string|null $dal3
 * @property string|null $al3
 * @property string|null $dal4
 * @property string|null $al4
 * @property string|null $dal5
 * @property string|null $al5
 * @property string|null $dal6
 * @property string|null $al6
 * @property string|null $dal7
 * @property string|null $al7
 * @property string|null $libe1
 * @property string|null $libe2
 * @property string|null $ann20
 *
 * @method static Builder|Est20f newModelQuery()
 * @method static Builder|Est20f newQuery()
 * @method static Builder|Est20f query()
 * @method static Builder|Est20f whereAl1($value)
 * @method static Builder|Est20f whereAl2($value)
 * @method static Builder|Est20f whereAl3($value)
 * @method static Builder|Est20f whereAl4($value)
 * @method static Builder|Est20f whereAl5($value)
 * @method static Builder|Est20f whereAl6($value)
 * @method static Builder|Est20f whereAl7($value)
 * @method static Builder|Est20f whereAnn20($value)
 * @method static Builder|Est20f whereAuto1($value)
 * @method static Builder|Est20f whereAuto2($value)
 * @method static Builder|Est20f whereAuto3($value)
 * @method static Builder|Est20f whereCommi1($value)
 * @method static Builder|Est20f whereCommi2($value)
 * @method static Builder|Est20f whereCommi3($value)
 * @method static Builder|Est20f whereCommi4($value)
 * @method static Builder|Est20f whereCommi5($value)
 * @method static Builder|Est20f whereCommi6($value)
 * @method static Builder|Est20f whereCommi7($value)
 * @method static Builder|Est20f whereDal1($value)
 * @method static Builder|Est20f whereDal2($value)
 * @method static Builder|Est20f whereDal3($value)
 * @method static Builder|Est20f whereDal4($value)
 * @method static Builder|Est20f whereDal5($value)
 * @method static Builder|Est20f whereDal6($value)
 * @method static Builder|Est20f whereDal7($value)
 * @method static Builder|Est20f whereEnte($value)
 * @method static Builder|Est20f whereId($value)
 * @method static Builder|Est20f whereLibe1($value)
 * @method static Builder|Est20f whereLibe2($value)
 * @method static Builder|Est20f whereMatr($value)
 * @method static Builder|Est20f whereTarif1($value)
 * @method static Builder|Est20f whereTarif2($value)
 * @method static Builder|Est20f whereTarif3($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est20fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est20f extends BaseModel
{
    protected $table = 'est20f';
}
