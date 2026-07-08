<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Rep00k4.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $repdal
 * @property int $repal
 * @property int $repst1
 * @property int $repre1
 * @property int $repst2
 * @property int $repre2
 * @property int $repcla
 * @property int $repmar
 * @property string $grppag
 * @property int $numpag
 * @property int $repc1a
 * @property int $repc1b
 * @property int $repc1c
 * @property int $repc2a
 * @property int $repc2b
 * @property int $repc2c
 * @property int $repc3a
 * @property int $repc3b
 * @property int $repc3c
 * @property string $perc1
 * @property string $perc2
 * @property string $perc3
 * @property int $piaorg
 * @property string $repann
 * @property int $rep2kd
 * @property int $rep2ka
 * @property int $rep001
 * @property string $rep002
 * @property string $rep003
 * @property int $rep004
 * @property int $rep005
 *
 * @method static Builder|Rep00k4 newModelQuery()
 * @method static Builder|Rep00k4 newQuery()
 * @method static Builder|Rep00k4 query()
 * @method static Builder|Rep00k4 whereEnte($value)
 * @method static Builder|Rep00k4 whereGrppag($value)
 * @method static Builder|Rep00k4 whereId($value)
 * @method static Builder|Rep00k4 whereMatr($value)
 * @method static Builder|Rep00k4 whereNumpag($value)
 * @method static Builder|Rep00k4 wherePerc1($value)
 * @method static Builder|Rep00k4 wherePerc2($value)
 * @method static Builder|Rep00k4 wherePerc3($value)
 * @method static Builder|Rep00k4 wherePiaorg($value)
 * @method static Builder|Rep00k4 whereRep001($value)
 * @method static Builder|Rep00k4 whereRep002($value)
 * @method static Builder|Rep00k4 whereRep003($value)
 * @method static Builder|Rep00k4 whereRep004($value)
 * @method static Builder|Rep00k4 whereRep005($value)
 * @method static Builder|Rep00k4 whereRep2ka($value)
 * @method static Builder|Rep00k4 whereRep2kd($value)
 * @method static Builder|Rep00k4 whereRepal($value)
 * @method static Builder|Rep00k4 whereRepann($value)
 * @method static Builder|Rep00k4 whereRepc1a($value)
 * @method static Builder|Rep00k4 whereRepc1b($value)
 * @method static Builder|Rep00k4 whereRepc1c($value)
 * @method static Builder|Rep00k4 whereRepc2a($value)
 * @method static Builder|Rep00k4 whereRepc2b($value)
 * @method static Builder|Rep00k4 whereRepc2c($value)
 * @method static Builder|Rep00k4 whereRepc3a($value)
 * @method static Builder|Rep00k4 whereRepc3b($value)
 * @method static Builder|Rep00k4 whereRepc3c($value)
 * @method static Builder|Rep00k4 whereRepcla($value)
 * @method static Builder|Rep00k4 whereRepdal($value)
 * @method static Builder|Rep00k4 whereRepmar($value)
 * @method static Builder|Rep00k4 whereRepre1($value)
 * @method static Builder|Rep00k4 whereRepre2($value)
 * @method static Builder|Rep00k4 whereRepst1($value)
 * @method static Builder|Rep00k4 whereRepst2($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Rep00k4Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Rep00k4 extends BaseModel
{
    protected $table = 'rep00k4';
}
