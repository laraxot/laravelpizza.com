<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mdis00l2.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $mdannu
 * @property string|null $mdmatr
 * @property string|null $mddalg
 * @property string|null $mdalg
 * @property string|null $mddall
 * @property string|null $mdalle
 * @property string|null $mdflg1
 * @property string|null $mdcom1
 * @property string|null $mdflag
 * @property string|null $mdindi
 * @property string|null $mdcom2
 * @property string|null $mdcom3
 * @property string|null $mdcom4
 * @property string|null $mdcom5
 *
 * @method static Builder|Mdis00l2 newModelQuery()
 * @method static Builder|Mdis00l2 newQuery()
 * @method static Builder|Mdis00l2 query()
 * @method static Builder|Mdis00l2 whereEnteap($value)
 * @method static Builder|Mdis00l2 whereId($value)
 * @method static Builder|Mdis00l2 whereMdalg($value)
 * @method static Builder|Mdis00l2 whereMdalle($value)
 * @method static Builder|Mdis00l2 whereMdannu($value)
 * @method static Builder|Mdis00l2 whereMdcom1($value)
 * @method static Builder|Mdis00l2 whereMdcom2($value)
 * @method static Builder|Mdis00l2 whereMdcom3($value)
 * @method static Builder|Mdis00l2 whereMdcom4($value)
 * @method static Builder|Mdis00l2 whereMdcom5($value)
 * @method static Builder|Mdis00l2 whereMddalg($value)
 * @method static Builder|Mdis00l2 whereMddall($value)
 * @method static Builder|Mdis00l2 whereMdflag($value)
 * @method static Builder|Mdis00l2 whereMdflg1($value)
 * @method static Builder|Mdis00l2 whereMdindi($value)
 * @method static Builder|Mdis00l2 whereMdmatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mdis00l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mdis00l2 extends BaseModel
{
    protected $table = 'mdis00l2';
}
