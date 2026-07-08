<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua04k1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $q4tipo
 * @property int|null $q4dal
 * @property int|null $q4al
 * @property int|null $q4seq
 * @property string|null $q4desc
 * @property string|null $q4des2
 * @property string|null $q4des3
 * @property int|null $q4cont
 * @property int|null $q4pro
 * @property int|null $q4fun
 * @property int|null $q4man
 * @property int|null $q4dis
 * @property int|null $q4scad
 * @property int|null $q4tip
 * @property int|null $q4dat
 * @property string|null $q4num
 * @property int|null $q4tia
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
 * @property int|null $q4001
 * @property string|null $q4002
 * @property string|null $q4003
 * @property int|null $q4004
 * @property int|null $q4005
 *
 * @method static Builder|Qua04k1 newModelQuery()
 * @method static Builder|Qua04k1 newQuery()
 * @method static Builder|Qua04k1 query()
 * @method static Builder|Qua04k1 whereEnte($value)
 * @method static Builder|Qua04k1 whereId($value)
 * @method static Builder|Qua04k1 whereMatr($value)
 * @method static Builder|Qua04k1 whereQ4001($value)
 * @method static Builder|Qua04k1 whereQ4002($value)
 * @method static Builder|Qua04k1 whereQ4003($value)
 * @method static Builder|Qua04k1 whereQ4004($value)
 * @method static Builder|Qua04k1 whereQ4005($value)
 * @method static Builder|Qua04k1 whereQ4al($value)
 * @method static Builder|Qua04k1 whereQ4ann($value)
 * @method static Builder|Qua04k1 whereQ4cm01($value)
 * @method static Builder|Qua04k1 whereQ4cm02($value)
 * @method static Builder|Qua04k1 whereQ4cm03($value)
 * @method static Builder|Qua04k1 whereQ4cm04($value)
 * @method static Builder|Qua04k1 whereQ4cm05($value)
 * @method static Builder|Qua04k1 whereQ4cm06($value)
 * @method static Builder|Qua04k1 whereQ4cm07($value)
 * @method static Builder|Qua04k1 whereQ4cm08($value)
 * @method static Builder|Qua04k1 whereQ4cm09($value)
 * @method static Builder|Qua04k1 whereQ4cm10($value)
 * @method static Builder|Qua04k1 whereQ4cm11($value)
 * @method static Builder|Qua04k1 whereQ4cm12($value)
 * @method static Builder|Qua04k1 whereQ4cm13($value)
 * @method static Builder|Qua04k1 whereQ4cm14($value)
 * @method static Builder|Qua04k1 whereQ4cm15($value)
 * @method static Builder|Qua04k1 whereQ4cm16($value)
 * @method static Builder|Qua04k1 whereQ4cm17($value)
 * @method static Builder|Qua04k1 whereQ4cm18($value)
 * @method static Builder|Qua04k1 whereQ4cm19($value)
 * @method static Builder|Qua04k1 whereQ4cm20($value)
 * @method static Builder|Qua04k1 whereQ4cont($value)
 * @method static Builder|Qua04k1 whereQ4dal($value)
 * @method static Builder|Qua04k1 whereQ4dat($value)
 * @method static Builder|Qua04k1 whereQ4des2($value)
 * @method static Builder|Qua04k1 whereQ4des3($value)
 * @method static Builder|Qua04k1 whereQ4desc($value)
 * @method static Builder|Qua04k1 whereQ4dis($value)
 * @method static Builder|Qua04k1 whereQ4fun($value)
 * @method static Builder|Qua04k1 whereQ4man($value)
 * @method static Builder|Qua04k1 whereQ4num($value)
 * @method static Builder|Qua04k1 whereQ4pro($value)
 * @method static Builder|Qua04k1 whereQ4scad($value)
 * @method static Builder|Qua04k1 whereQ4seq($value)
 * @method static Builder|Qua04k1 whereQ4sta($value)
 * @method static Builder|Qua04k1 whereQ4tia($value)
 * @method static Builder|Qua04k1 whereQ4tip($value)
 * @method static Builder|Qua04k1 whereQ4tipo($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua04k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua04k1 extends BaseModel
{
    protected $table = 'qua04k1';
}
