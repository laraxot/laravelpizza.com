<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wmen00l4.
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
 * @method static Builder|Wmen00l4 newModelQuery()
 * @method static Builder|Wmen00l4 newQuery()
 * @method static Builder|Wmen00l4 query()
 * @method static Builder|Wmen00l4 whereEnteap($value)
 * @method static Builder|Wmen00l4 whereId($value)
 * @method static Builder|Wmen00l4 whereMnannu($value)
 * @method static Builder|Wmen00l4 whereMnbadg($value)
 * @method static Builder|Wmen00l4 whereMncaus($value)
 * @method static Builder|Wmen00l4 whereMncogn($value)
 * @method static Builder|Wmen00l4 whereMncom2($value)
 * @method static Builder|Wmen00l4 whereMncom3($value)
 * @method static Builder|Wmen00l4 whereMndata($value)
 * @method static Builder|Wmen00l4 whereMnflg1($value)
 * @method static Builder|Wmen00l4 whereMnflg2($value)
 * @method static Builder|Wmen00l4 whereMnflg3($value)
 * @method static Builder|Wmen00l4 whereMnflg4($value)
 * @method static Builder|Wmen00l4 whereMnmatr($value)
 * @method static Builder|Wmen00l4 whereMnnome($value)
 * @method static Builder|Wmen00l4 whereMnorat($value)
 * @method static Builder|Wmen00l4 whereMnp1($value)
 * @method static Builder|Wmen00l4 whereMnp2($value)
 * @method static Builder|Wmen00l4 whereMnp3($value)
 * @method static Builder|Wmen00l4 whereMnp4($value)
 * @method static Builder|Wmen00l4 whereMntmen($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wmen00l4Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wmen00l4 extends BaseModel
{
    protected $table = 'wmen00l4';
}
