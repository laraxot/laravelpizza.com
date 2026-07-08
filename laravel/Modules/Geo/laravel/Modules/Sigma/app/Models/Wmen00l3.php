<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wmen00l3.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $mnannu
 * @property string|null $mnbadg
 * @property string|null $mnmatr
 * @property string|null $mncogn
 * @property string|null $mnnome
 * @property string|null $mncaus
 * @property string|null $mnp1
 * @property string|null $mnp2
 * @property string|null $mnp3
 * @property string|null $mnp4
 * @property string|null $mndata
 * @property string|null $mnorat
 * @property string|null $mnflg1
 * @property string|null $mnflg2
 * @property string|null $mnflg3
 * @property string|null $mnflg4
 * @property string|null $mntmen
 * @property string|null $mncom2
 * @property string|null $mncom3
 *
 * @method static Builder|Wmen00l3 newModelQuery()
 * @method static Builder|Wmen00l3 newQuery()
 * @method static Builder|Wmen00l3 query()
 * @method static Builder|Wmen00l3 whereEnteap($value)
 * @method static Builder|Wmen00l3 whereId($value)
 * @method static Builder|Wmen00l3 whereMnannu($value)
 * @method static Builder|Wmen00l3 whereMnbadg($value)
 * @method static Builder|Wmen00l3 whereMncaus($value)
 * @method static Builder|Wmen00l3 whereMncogn($value)
 * @method static Builder|Wmen00l3 whereMncom2($value)
 * @method static Builder|Wmen00l3 whereMncom3($value)
 * @method static Builder|Wmen00l3 whereMndata($value)
 * @method static Builder|Wmen00l3 whereMnflg1($value)
 * @method static Builder|Wmen00l3 whereMnflg2($value)
 * @method static Builder|Wmen00l3 whereMnflg3($value)
 * @method static Builder|Wmen00l3 whereMnflg4($value)
 * @method static Builder|Wmen00l3 whereMnmatr($value)
 * @method static Builder|Wmen00l3 whereMnnome($value)
 * @method static Builder|Wmen00l3 whereMnorat($value)
 * @method static Builder|Wmen00l3 whereMnp1($value)
 * @method static Builder|Wmen00l3 whereMnp2($value)
 * @method static Builder|Wmen00l3 whereMnp3($value)
 * @method static Builder|Wmen00l3 whereMnp4($value)
 * @method static Builder|Wmen00l3 whereMntmen($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wmen00l3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wmen00l3 extends BaseModel
{
    protected $table = 'wmen00l3';
}
