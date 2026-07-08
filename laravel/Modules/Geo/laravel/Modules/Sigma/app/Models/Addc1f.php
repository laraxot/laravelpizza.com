<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Addc1f.
 *
 * @property int $id
 * @property string|null $addist
 * @property string|null $addper
 * @property string|null $adddal
 * @property string|null $addal
 * @property string|null $addim1
 * @property string|null $addim2
 * @property string|null $addim3
 * @property string|null $addfra
 *
 * @method static Builder|Addc1f newModelQuery()
 * @method static Builder|Addc1f newQuery()
 * @method static Builder|Addc1f query()
 * @method static Builder|Addc1f whereAddal($value)
 * @method static Builder|Addc1f whereAdddal($value)
 * @method static Builder|Addc1f whereAddfra($value)
 * @method static Builder|Addc1f whereAddim1($value)
 * @method static Builder|Addc1f whereAddim2($value)
 * @method static Builder|Addc1f whereAddim3($value)
 * @method static Builder|Addc1f whereAddist($value)
 * @method static Builder|Addc1f whereAddper($value)
 * @method static Builder|Addc1f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Addc1fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Addc1f extends BaseModel
{
    protected $table = 'addc1f';
}
