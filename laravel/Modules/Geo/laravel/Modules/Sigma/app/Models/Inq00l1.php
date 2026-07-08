<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Inq00l1.
 *
 * @property int $id
 * @property string|null $cont
 * @property string|null $codinq
 * @property string|null $inqdal
 * @property string|null $inqal
 * @property string|null $strvoc
 * @property string|null $stvocn
 * @property string|null $inann
 *
 * @method static Builder|Inq00l1 newModelQuery()
 * @method static Builder|Inq00l1 newQuery()
 * @method static Builder|Inq00l1 query()
 * @method static Builder|Inq00l1 whereCodinq($value)
 * @method static Builder|Inq00l1 whereCont($value)
 * @method static Builder|Inq00l1 whereId($value)
 * @method static Builder|Inq00l1 whereInann($value)
 * @method static Builder|Inq00l1 whereInqal($value)
 * @method static Builder|Inq00l1 whereInqdal($value)
 * @method static Builder|Inq00l1 whereStrvoc($value)
 * @method static Builder|Inq00l1 whereStvocn($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Inq00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Inq00l1 extends BaseModel
{
    protected $table = 'inq00l1';
}
