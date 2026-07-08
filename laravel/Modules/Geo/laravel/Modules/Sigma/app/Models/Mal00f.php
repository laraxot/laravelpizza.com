<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mal00f.
 *
 * @property int $id
 * @property string|null $codm
 * @property string|null $codms
 * @property string|null $descm
 *
 * @method static Builder|Mal00f newModelQuery()
 * @method static Builder|Mal00f newQuery()
 * @method static Builder|Mal00f query()
 * @method static Builder|Mal00f whereCodm($value)
 * @method static Builder|Mal00f whereCodms($value)
 * @method static Builder|Mal00f whereDescm($value)
 * @method static Builder|Mal00f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mal00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mal00f extends BaseModel
{
    protected $table = 'mal00f';
}
