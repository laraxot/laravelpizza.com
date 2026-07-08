<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wmen00l1.
 *
 * @property int $id
 * @property int|null $enteap
 * @property string|null $mnannu
 * @property int|null $mnbadg
 * @property int|null $mnmatr
 * @property string|null $mncogn
 * @property string|null $mnnome
 * @property int|null $mncaus
 * @property int|null $mnp1
 * @property int|null $mnp2
 * @property int|null $mnp3
 * @property int|null $mnp4
 * @property int|null $mndata
 * @property int|null $mnorat
 * @property string|null $mnflg1
 * @property string|null $mnflg2
 * @property int|null $mnflg3
 * @property string|null $mnflg4
 * @property int|null $mntmen
 * @property string|null $mncom2
 * @property int|null $mncom3
 * @property string|null $ixterm
 *
 * @method static Builder|Wmen00l1 newModelQuery()
 * @method static Builder|Wmen00l1 newQuery()
 * @method static Builder|Wmen00l1 query()
 * @method static Builder|Wmen00l1 whereEnteap($value)
 * @method static Builder|Wmen00l1 whereId($value)
 * @method static Builder|Wmen00l1 whereIxterm($value)
 * @method static Builder|Wmen00l1 whereMnannu($value)
 * @method static Builder|Wmen00l1 whereMnbadg($value)
 * @method static Builder|Wmen00l1 whereMncaus($value)
 * @method static Builder|Wmen00l1 whereMncogn($value)
 * @method static Builder|Wmen00l1 whereMncom2($value)
 * @method static Builder|Wmen00l1 whereMncom3($value)
 * @method static Builder|Wmen00l1 whereMndata($value)
 * @method static Builder|Wmen00l1 whereMnflg1($value)
 * @method static Builder|Wmen00l1 whereMnflg2($value)
 * @method static Builder|Wmen00l1 whereMnflg3($value)
 * @method static Builder|Wmen00l1 whereMnflg4($value)
 * @method static Builder|Wmen00l1 whereMnmatr($value)
 * @method static Builder|Wmen00l1 whereMnnome($value)
 * @method static Builder|Wmen00l1 whereMnorat($value)
 * @method static Builder|Wmen00l1 whereMnp1($value)
 * @method static Builder|Wmen00l1 whereMnp2($value)
 * @method static Builder|Wmen00l1 whereMnp3($value)
 * @method static Builder|Wmen00l1 whereMnp4($value)
 * @method static Builder|Wmen00l1 whereMntmen($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wmen00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wmen00l1 extends BaseModel
{
    protected $table = 'wmen00l1';
}
