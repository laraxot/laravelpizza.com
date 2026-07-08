<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua03k1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $q3tipo
 * @property int|null $q3dal
 * @property int|null $q3al
 * @property string|null $q3desc
 * @property string|null $q3des2
 * @property string|null $q3des3
 * @property int|null $q3cont
 * @property int|null $q3pro
 * @property int|null $q3fun
 * @property int|null $q3man
 * @property int|null $q3dis
 * @property int|null $q3voc1
 * @property int|null $q3anz1
 * @property int|null $q3imp1
 * @property string|null $q3eur1
 * @property int|null $q3voc2
 * @property int|null $q3anz2
 * @property int|null $q3imp2
 * @property string|null $q3eur2
 * @property int|null $q3voc3
 * @property int|null $q3anz3
 * @property int|null $q3imp3
 * @property string|null $q3eur3
 * @property int|null $q3voc4
 * @property int|null $q3anz4
 * @property int|null $q3imp4
 * @property string|null $q3eur4
 * @property int|null $q3voc5
 * @property int|null $q3anz5
 * @property int|null $q3imp5
 * @property string|null $q3eur5
 * @property int|null $q3tip
 * @property int|null $q3dat
 * @property string|null $q3num
 * @property string|null $q3ann
 * @property int|null $q32kd
 * @property int|null $q32ka
 * @property int|null $q32ka1
 * @property int|null $q32ka2
 * @property int|null $q32ka3
 * @property int|null $q32ka4
 * @property int|null $q32ka5
 * @property int|null $q32k
 * @property int|null $q3001
 * @property string|null $q3002
 * @property string|null $q3003
 * @property int|null $q3004
 * @property int|null $q3005
 *
 * @method static Builder|Qua03k1 newModelQuery()
 * @method static Builder|Qua03k1 newQuery()
 * @method static Builder|Qua03k1 query()
 * @method static Builder|Qua03k1 whereEnte($value)
 * @method static Builder|Qua03k1 whereId($value)
 * @method static Builder|Qua03k1 whereMatr($value)
 * @method static Builder|Qua03k1 whereQ3001($value)
 * @method static Builder|Qua03k1 whereQ3002($value)
 * @method static Builder|Qua03k1 whereQ3003($value)
 * @method static Builder|Qua03k1 whereQ3004($value)
 * @method static Builder|Qua03k1 whereQ3005($value)
 * @method static Builder|Qua03k1 whereQ32k($value)
 * @method static Builder|Qua03k1 whereQ32ka($value)
 * @method static Builder|Qua03k1 whereQ32ka1($value)
 * @method static Builder|Qua03k1 whereQ32ka2($value)
 * @method static Builder|Qua03k1 whereQ32ka3($value)
 * @method static Builder|Qua03k1 whereQ32ka4($value)
 * @method static Builder|Qua03k1 whereQ32ka5($value)
 * @method static Builder|Qua03k1 whereQ32kd($value)
 * @method static Builder|Qua03k1 whereQ3al($value)
 * @method static Builder|Qua03k1 whereQ3ann($value)
 * @method static Builder|Qua03k1 whereQ3anz1($value)
 * @method static Builder|Qua03k1 whereQ3anz2($value)
 * @method static Builder|Qua03k1 whereQ3anz3($value)
 * @method static Builder|Qua03k1 whereQ3anz4($value)
 * @method static Builder|Qua03k1 whereQ3anz5($value)
 * @method static Builder|Qua03k1 whereQ3cont($value)
 * @method static Builder|Qua03k1 whereQ3dal($value)
 * @method static Builder|Qua03k1 whereQ3dat($value)
 * @method static Builder|Qua03k1 whereQ3des2($value)
 * @method static Builder|Qua03k1 whereQ3des3($value)
 * @method static Builder|Qua03k1 whereQ3desc($value)
 * @method static Builder|Qua03k1 whereQ3dis($value)
 * @method static Builder|Qua03k1 whereQ3eur1($value)
 * @method static Builder|Qua03k1 whereQ3eur2($value)
 * @method static Builder|Qua03k1 whereQ3eur3($value)
 * @method static Builder|Qua03k1 whereQ3eur4($value)
 * @method static Builder|Qua03k1 whereQ3eur5($value)
 * @method static Builder|Qua03k1 whereQ3fun($value)
 * @method static Builder|Qua03k1 whereQ3imp1($value)
 * @method static Builder|Qua03k1 whereQ3imp2($value)
 * @method static Builder|Qua03k1 whereQ3imp3($value)
 * @method static Builder|Qua03k1 whereQ3imp4($value)
 * @method static Builder|Qua03k1 whereQ3imp5($value)
 * @method static Builder|Qua03k1 whereQ3man($value)
 * @method static Builder|Qua03k1 whereQ3num($value)
 * @method static Builder|Qua03k1 whereQ3pro($value)
 * @method static Builder|Qua03k1 whereQ3tip($value)
 * @method static Builder|Qua03k1 whereQ3tipo($value)
 * @method static Builder|Qua03k1 whereQ3voc1($value)
 * @method static Builder|Qua03k1 whereQ3voc2($value)
 * @method static Builder|Qua03k1 whereQ3voc3($value)
 * @method static Builder|Qua03k1 whereQ3voc4($value)
 * @method static Builder|Qua03k1 whereQ3voc5($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua03k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua03k1 extends BaseModel
{
    protected $table = 'qua03k1';
}
