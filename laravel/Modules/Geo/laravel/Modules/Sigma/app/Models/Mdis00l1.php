<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mdis00l1.
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
 * @method static Builder|Mdis00l1 newModelQuery()
 * @method static Builder|Mdis00l1 newQuery()
 * @method static Builder|Mdis00l1 query()
 * @method static Builder|Mdis00l1 whereEnteap($value)
 * @method static Builder|Mdis00l1 whereId($value)
 * @method static Builder|Mdis00l1 whereMdalg($value)
 * @method static Builder|Mdis00l1 whereMdalle($value)
 * @method static Builder|Mdis00l1 whereMdannu($value)
 * @method static Builder|Mdis00l1 whereMdcom1($value)
 * @method static Builder|Mdis00l1 whereMdcom2($value)
 * @method static Builder|Mdis00l1 whereMdcom3($value)
 * @method static Builder|Mdis00l1 whereMdcom4($value)
 * @method static Builder|Mdis00l1 whereMdcom5($value)
 * @method static Builder|Mdis00l1 whereMddalg($value)
 * @method static Builder|Mdis00l1 whereMddall($value)
 * @method static Builder|Mdis00l1 whereMdflag($value)
 * @method static Builder|Mdis00l1 whereMdflg1($value)
 * @method static Builder|Mdis00l1 whereMdindi($value)
 * @method static Builder|Mdis00l1 whereMdmatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mdis00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mdis00l1 extends BaseModel
{
    protected $table = 'mdis00l1';
}
