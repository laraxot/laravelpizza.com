<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua04f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $q4tipo
 * @property string|null $q4dal
 * @property string|null $q4al
 * @property string|null $q4seq
 * @property string|null $q4desc
 * @property string|null $q4des2
 * @property string|null $q4des3
 * @property string|null $q4cont
 * @property string|null $q4pro
 * @property string|null $q4fun
 * @property string|null $q4man
 * @property string|null $q4dis
 * @property string|null $q4scad
 * @property string|null $q4tip
 * @property string|null $q4dat
 * @property string|null $q4num
 * @property string|null $q4tia
 * @property string|null $q4sta
 * @property string|null $q4cm01
 * @property string|null $q4cm02
 * @property string|null $q4cm03
 * @property string|null $q4cm04
 * @property string|null $q4cm05
 * @property string|null $q4cm06
 * @property string|null $q4cm07
 * @property string|null $q4cm08
 * @property string|null $q4cm09
 * @property string|null $q4cm10
 * @property string|null $q4cm11
 * @property string|null $q4cm12
 * @property string|null $q4cm13
 * @property string|null $q4cm14
 * @property string|null $q4cm15
 * @property string|null $q4cm16
 * @property string|null $q4cm17
 * @property string|null $q4cm18
 * @property string|null $q4cm19
 * @property string|null $q4cm20
 * @property string|null $q4ann
 * @property string|null $q4001
 * @property string|null $q4002
 * @property string|null $q4003
 * @property string|null $q4004
 * @property string|null $q4005
 *
 * @method static Builder|Qua04f newModelQuery()
 * @method static Builder|Qua04f newQuery()
 * @method static Builder|Qua04f query()
 * @method static Builder|Qua04f whereEnte($value)
 * @method static Builder|Qua04f whereId($value)
 * @method static Builder|Qua04f whereMatr($value)
 * @method static Builder|Qua04f whereQ4001($value)
 * @method static Builder|Qua04f whereQ4002($value)
 * @method static Builder|Qua04f whereQ4003($value)
 * @method static Builder|Qua04f whereQ4004($value)
 * @method static Builder|Qua04f whereQ4005($value)
 * @method static Builder|Qua04f whereQ4al($value)
 * @method static Builder|Qua04f whereQ4ann($value)
 * @method static Builder|Qua04f whereQ4cm01($value)
 * @method static Builder|Qua04f whereQ4cm02($value)
 * @method static Builder|Qua04f whereQ4cm03($value)
 * @method static Builder|Qua04f whereQ4cm04($value)
 * @method static Builder|Qua04f whereQ4cm05($value)
 * @method static Builder|Qua04f whereQ4cm06($value)
 * @method static Builder|Qua04f whereQ4cm07($value)
 * @method static Builder|Qua04f whereQ4cm08($value)
 * @method static Builder|Qua04f whereQ4cm09($value)
 * @method static Builder|Qua04f whereQ4cm10($value)
 * @method static Builder|Qua04f whereQ4cm11($value)
 * @method static Builder|Qua04f whereQ4cm12($value)
 * @method static Builder|Qua04f whereQ4cm13($value)
 * @method static Builder|Qua04f whereQ4cm14($value)
 * @method static Builder|Qua04f whereQ4cm15($value)
 * @method static Builder|Qua04f whereQ4cm16($value)
 * @method static Builder|Qua04f whereQ4cm17($value)
 * @method static Builder|Qua04f whereQ4cm18($value)
 * @method static Builder|Qua04f whereQ4cm19($value)
 * @method static Builder|Qua04f whereQ4cm20($value)
 * @method static Builder|Qua04f whereQ4cont($value)
 * @method static Builder|Qua04f whereQ4dal($value)
 * @method static Builder|Qua04f whereQ4dat($value)
 * @method static Builder|Qua04f whereQ4des2($value)
 * @method static Builder|Qua04f whereQ4des3($value)
 * @method static Builder|Qua04f whereQ4desc($value)
 * @method static Builder|Qua04f whereQ4dis($value)
 * @method static Builder|Qua04f whereQ4fun($value)
 * @method static Builder|Qua04f whereQ4man($value)
 * @method static Builder|Qua04f whereQ4num($value)
 * @method static Builder|Qua04f whereQ4pro($value)
 * @method static Builder|Qua04f whereQ4scad($value)
 * @method static Builder|Qua04f whereQ4seq($value)
 * @method static Builder|Qua04f whereQ4sta($value)
 * @method static Builder|Qua04f whereQ4tia($value)
 * @method static Builder|Qua04f whereQ4tip($value)
 * @method static Builder|Qua04f whereQ4tipo($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua04fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua04f extends BaseModel
{
    protected $table = 'qua04f';
}
