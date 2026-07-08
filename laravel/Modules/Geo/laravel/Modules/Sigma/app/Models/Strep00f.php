<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Strep00f.
 *
 * @property int $id
 *
 * @method static Builder|Strep00f newModelQuery()
 * @method static Builder|Strep00f newQuery()
 * @method static Builder|Strep00f query()
 * @method static Builder|Strep00f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Strep00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Strep00f extends BaseModel
{
    protected $table = 'strep00f';
}
