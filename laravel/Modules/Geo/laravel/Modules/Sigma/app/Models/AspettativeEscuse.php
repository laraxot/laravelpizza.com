<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\AspettativeEscuse.
 *
 * @method static Builder|AspettativeEscuse newModelQuery()
 * @method static Builder|AspettativeEscuse newQuery()
 * @method static Builder|AspettativeEscuse query()
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AspettativeEscuseFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class AspettativeEscuse extends BaseModel
{
    protected $table = 'aspettativeescuse';
}
