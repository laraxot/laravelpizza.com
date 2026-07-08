<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wgiu03lx.
 *
 * @property int $id
 * @property string|null $g3annu
 * @property int|null $enteap
 * @property int|null $stdata
 * @property int|null $g3matr
 * @property int|null $lecod1
 * @property int|null $lecod2
 * @property int|null $g3qtaa
 * @property string|null $g3qtav
 * @property string|null $g3orad
 * @property string|null $g3oraa
 * @property string|null $g3umis
 * @property int|null $g3qtar
 * @property string|null $g3flgs
 * @property string|null $g3flg1
 * @property string|null $g3com1
 * @property int|null $g3com2
 * @property int|null $g3com3
 * @property int|null $g3com4
 * @property int|null $g3com5
 * @property string|null $g3com6
 * @property int|null $g3com7
 * @property string|null $g3impe
 * @property string|null $g3unmi
 *
 * @method static Builder|Wgiu03lx newModelQuery()
 * @method static Builder|Wgiu03lx newQuery()
 * @method static Builder|Wgiu03lx query()
 * @method static Builder|Wgiu03lx whereEnteap($value)
 * @method static Builder|Wgiu03lx whereG3annu($value)
 * @method static Builder|Wgiu03lx whereG3com1($value)
 * @method static Builder|Wgiu03lx whereG3com2($value)
 * @method static Builder|Wgiu03lx whereG3com3($value)
 * @method static Builder|Wgiu03lx whereG3com4($value)
 * @method static Builder|Wgiu03lx whereG3com5($value)
 * @method static Builder|Wgiu03lx whereG3com6($value)
 * @method static Builder|Wgiu03lx whereG3com7($value)
 * @method static Builder|Wgiu03lx whereG3flg1($value)
 * @method static Builder|Wgiu03lx whereG3flgs($value)
 * @method static Builder|Wgiu03lx whereG3impe($value)
 * @method static Builder|Wgiu03lx whereG3matr($value)
 * @method static Builder|Wgiu03lx whereG3oraa($value)
 * @method static Builder|Wgiu03lx whereG3orad($value)
 * @method static Builder|Wgiu03lx whereG3qtaa($value)
 * @method static Builder|Wgiu03lx whereG3qtar($value)
 * @method static Builder|Wgiu03lx whereG3qtav($value)
 * @method static Builder|Wgiu03lx whereG3umis($value)
 * @method static Builder|Wgiu03lx whereG3unmi($value)
 * @method static Builder|Wgiu03lx whereId($value)
 * @method static Builder|Wgiu03lx whereLecod1($value)
 * @method static Builder|Wgiu03lx whereLecod2($value)
 * @method static Builder|Wgiu03lx whereStdata($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wgiu03lxFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wgiu03lx extends BaseModel
{
    protected $table = 'wgiu03lx';
}
