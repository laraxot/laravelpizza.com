<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wcom00f.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $comatr
 * @property string|null $codata
 * @property string|null $cocomm
 *
 * @method static Builder|Wcom00f newModelQuery()
 * @method static Builder|Wcom00f newQuery()
 * @method static Builder|Wcom00f query()
 * @method static Builder|Wcom00f whereCocomm($value)
 * @method static Builder|Wcom00f whereCodata($value)
 * @method static Builder|Wcom00f whereComatr($value)
 * @method static Builder|Wcom00f whereEnteap($value)
 * @method static Builder|Wcom00f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wcom00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wcom00f extends BaseModel
{
    protected $table = 'wcom00f';
}
