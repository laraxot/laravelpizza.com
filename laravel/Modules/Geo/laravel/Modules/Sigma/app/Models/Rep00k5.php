<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Rep00k5.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $repdal
 * @property string|null $repal
 * @property string|null $repst1
 * @property string|null $repre1
 * @property string|null $repst2
 * @property string|null $repre2
 * @property string|null $repcla
 * @property string|null $repmar
 * @property string|null $grppag
 * @property string|null $numpag
 * @property string|null $repc1a
 * @property string|null $repc1b
 * @property string|null $repc1c
 * @property string|null $repc2a
 * @property string|null $repc2b
 * @property string|null $repc2c
 * @property string|null $repc3a
 * @property string|null $repc3b
 * @property string|null $repc3c
 * @property string|null $perc1
 * @property string|null $perc2
 * @property string|null $perc3
 * @property string|null $piaorg
 * @property string|null $repann
 * @property string|null $rep2kd
 * @property string|null $rep2ka
 * @property string|null $rep001
 * @property string|null $rep002
 * @property string|null $rep003
 * @property string|null $rep004
 * @property string|null $rep005
 *
 * @method static Builder|Rep00k5 newModelQuery()
 * @method static Builder|Rep00k5 newQuery()
 * @method static Builder|Rep00k5 query()
 * @method static Builder|Rep00k5 whereEnte($value)
 * @method static Builder|Rep00k5 whereGrppag($value)
 * @method static Builder|Rep00k5 whereId($value)
 * @method static Builder|Rep00k5 whereMatr($value)
 * @method static Builder|Rep00k5 whereNumpag($value)
 * @method static Builder|Rep00k5 wherePerc1($value)
 * @method static Builder|Rep00k5 wherePerc2($value)
 * @method static Builder|Rep00k5 wherePerc3($value)
 * @method static Builder|Rep00k5 wherePiaorg($value)
 * @method static Builder|Rep00k5 whereRep001($value)
 * @method static Builder|Rep00k5 whereRep002($value)
 * @method static Builder|Rep00k5 whereRep003($value)
 * @method static Builder|Rep00k5 whereRep004($value)
 * @method static Builder|Rep00k5 whereRep005($value)
 * @method static Builder|Rep00k5 whereRep2ka($value)
 * @method static Builder|Rep00k5 whereRep2kd($value)
 * @method static Builder|Rep00k5 whereRepal($value)
 * @method static Builder|Rep00k5 whereRepann($value)
 * @method static Builder|Rep00k5 whereRepc1a($value)
 * @method static Builder|Rep00k5 whereRepc1b($value)
 * @method static Builder|Rep00k5 whereRepc1c($value)
 * @method static Builder|Rep00k5 whereRepc2a($value)
 * @method static Builder|Rep00k5 whereRepc2b($value)
 * @method static Builder|Rep00k5 whereRepc2c($value)
 * @method static Builder|Rep00k5 whereRepc3a($value)
 * @method static Builder|Rep00k5 whereRepc3b($value)
 * @method static Builder|Rep00k5 whereRepc3c($value)
 * @method static Builder|Rep00k5 whereRepcla($value)
 * @method static Builder|Rep00k5 whereRepdal($value)
 * @method static Builder|Rep00k5 whereRepmar($value)
 * @method static Builder|Rep00k5 whereRepre1($value)
 * @method static Builder|Rep00k5 whereRepre2($value)
 * @method static Builder|Rep00k5 whereRepst1($value)
 * @method static Builder|Rep00k5 whereRepst2($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Rep00k5Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Rep00k5 extends BaseModel
{
    protected $table = 'rep00k5';
}
