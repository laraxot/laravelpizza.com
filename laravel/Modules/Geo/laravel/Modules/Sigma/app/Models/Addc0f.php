<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Addc0f.
 *
 * @property int $id
 * @property int $addist
 * @property string $addper
 * @property int $adddal
 * @property int $addal
 *
 * @method static Builder|Addc0f newModelQuery()
 * @method static Builder|Addc0f newQuery()
 * @method static Builder|Addc0f query()
 * @method static Builder|Addc0f whereAddal($value)
 * @method static Builder|Addc0f whereAdddal($value)
 * @method static Builder|Addc0f whereAddist($value)
 * @method static Builder|Addc0f whereAddper($value)
 * @method static Builder|Addc0f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Addc0fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Addc0f extends BaseModel
{
    protected $table = 'addc0f';
}
