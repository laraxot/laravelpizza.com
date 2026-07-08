<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua03Ana.
 *
 * @method static Builder|Qua03Ana newModelQuery()
 * @method static Builder|Qua03Ana newQuery()
 * @method static Builder|Qua03Ana query()
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua03AnaFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua03Ana extends BaseModel
{
    protected $table = 'qua03ana';
}
