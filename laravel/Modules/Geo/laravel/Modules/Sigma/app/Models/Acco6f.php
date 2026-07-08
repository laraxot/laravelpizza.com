<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Acco6f.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $aumdal
 * @property int $aumimp
 *
 * @method static Builder|Acco6f newModelQuery()
 * @method static Builder|Acco6f newQuery()
 * @method static Builder|Acco6f query()
 * @method static Builder|Acco6f whereAumdal($value)
 * @method static Builder|Acco6f whereAumimp($value)
 * @method static Builder|Acco6f whereEnte($value)
 * @method static Builder|Acco6f whereId($value)
 * @method static Builder|Acco6f whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Acco6fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Acco6f extends BaseModel
{
    protected $table = 'acco6f';
}
