<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wgiu04f.
 *
 * @property int $id
 * @property string|null $g4annu
 * @property int|null $enteap
 * @property int|null $g4matr
 * @property int|null $g4aamm
 * @property int|null $g4sequ
 * @property int|null $g4cod1
 * @property int|null $g4cod2
 * @property int|null $g4qtaa
 * @property int|null $g4qtar
 * @property int|null $g4com3
 * @property int|null $g4com4
 * @property int|null $g4com5
 * @property string|null $g4com6
 *
 * @method static Builder|Wgiu04f newModelQuery()
 * @method static Builder|Wgiu04f newQuery()
 * @method static Builder|Wgiu04f query()
 * @method static Builder|Wgiu04f whereEnteap($value)
 * @method static Builder|Wgiu04f whereG4aamm($value)
 * @method static Builder|Wgiu04f whereG4annu($value)
 * @method static Builder|Wgiu04f whereG4cod1($value)
 * @method static Builder|Wgiu04f whereG4cod2($value)
 * @method static Builder|Wgiu04f whereG4com3($value)
 * @method static Builder|Wgiu04f whereG4com4($value)
 * @method static Builder|Wgiu04f whereG4com5($value)
 * @method static Builder|Wgiu04f whereG4com6($value)
 * @method static Builder|Wgiu04f whereG4matr($value)
 * @method static Builder|Wgiu04f whereG4qtaa($value)
 * @method static Builder|Wgiu04f whereG4qtar($value)
 * @method static Builder|Wgiu04f whereG4sequ($value)
 * @method static Builder|Wgiu04f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wgiu04fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wgiu04f extends BaseModel
{
    protected $table = 'wgiu04f';
}
