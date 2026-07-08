<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est20l1.
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
 * @method static Builder|Est20l1 newModelQuery()
 * @method static Builder|Est20l1 newQuery()
 * @method static Builder|Est20l1 query()
 * @method static Builder|Est20l1 whereAl1($value)
 * @method static Builder|Est20l1 whereAl2($value)
 * @method static Builder|Est20l1 whereAl3($value)
 * @method static Builder|Est20l1 whereAl4($value)
 * @method static Builder|Est20l1 whereAl5($value)
 * @method static Builder|Est20l1 whereAl6($value)
 * @method static Builder|Est20l1 whereAl7($value)
 * @method static Builder|Est20l1 whereAnn20($value)
 * @method static Builder|Est20l1 whereAuto1($value)
 * @method static Builder|Est20l1 whereAuto2($value)
 * @method static Builder|Est20l1 whereAuto3($value)
 * @method static Builder|Est20l1 whereCommi1($value)
 * @method static Builder|Est20l1 whereCommi2($value)
 * @method static Builder|Est20l1 whereCommi3($value)
 * @method static Builder|Est20l1 whereCommi4($value)
 * @method static Builder|Est20l1 whereCommi5($value)
 * @method static Builder|Est20l1 whereCommi6($value)
 * @method static Builder|Est20l1 whereCommi7($value)
 * @method static Builder|Est20l1 whereDal1($value)
 * @method static Builder|Est20l1 whereDal2($value)
 * @method static Builder|Est20l1 whereDal3($value)
 * @method static Builder|Est20l1 whereDal4($value)
 * @method static Builder|Est20l1 whereDal5($value)
 * @method static Builder|Est20l1 whereDal6($value)
 * @method static Builder|Est20l1 whereDal7($value)
 * @method static Builder|Est20l1 whereEnte($value)
 * @method static Builder|Est20l1 whereId($value)
 * @method static Builder|Est20l1 whereLibe1($value)
 * @method static Builder|Est20l1 whereLibe2($value)
 * @method static Builder|Est20l1 whereMatr($value)
 * @method static Builder|Est20l1 whereTarif1($value)
 * @method static Builder|Est20l1 whereTarif2($value)
 * @method static Builder|Est20l1 whereTarif3($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est20l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est20l1 extends BaseModel
{
    protected $table = 'est20l1';
}
