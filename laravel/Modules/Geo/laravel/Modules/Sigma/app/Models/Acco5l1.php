<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Acco5l1.
 *
 * @property int $id
 *
 * @method static Builder|Acco5l1 newModelQuery()
 * @method static Builder|Acco5l1 newQuery()
 * @method static Builder|Acco5l1 query()
 * @method static Builder|Acco5l1 whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Acco5l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Acco5l1 extends BaseModel
{
    protected $table = 'acco5l1';
}
